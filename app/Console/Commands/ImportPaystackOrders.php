<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Illuminate\Support\Str;

class ImportPaystackOrders extends Command
{
    protected $signature = 'paystack:import {--from=} {--to=}';
    protected $description = 'Fetch successful Paystack transactions and save missing orders';

    public function handle()
    {
        $secretKey = env('PAYSTACK_SECRET_KEY');

        $from = $this->option('from'); // optional date filter YYYY-MM-DD
        $to = $this->option('to');

        $this->info("Fetching Paystack transactions...");

        // Paystack transactions API
        $url = 'https://api.paystack.co/transaction';

        $params = [];
        if ($from) $params['from'] = strtotime($from);
        if ($to) $params['to'] = strtotime($to);

        $response = Http::withToken($secretKey)
                        ->get($url, $params);

        $data = $response->json();

        if(!isset($data['status']) || !$data['status']){
            $this->error("Failed to fetch transactions: " . ($data['message'] ?? 'Unknown error'));
            return;
        }

        $transactions = $data['data'] ?? [];

        $count = 0;

        foreach($transactions as $txn){
            if($txn['status'] !== 'success') continue;

            // Check if order already exists
            if(Order::where('payment_reference', $txn['reference'])->exists()) continue;

            // Create order
            Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(6)) . '-' . now()->format('ymd'),
                'user_id' => null, // optional, if guest
                'name' => $txn['customer']['first_name'] ?? $txn['customer']['email'],
                'phone' => $txn['customer']['phone'] ?? null,
                'email' => $txn['customer']['email'],
                'address' => null, // not provided by Paystack
                'city' => null,
                'state' => null,
                'payment_reference' => $txn['reference'],
                'amount' => $txn['amount'] / 100,
                'status' => 'paid',
                'meta' => [
                    'gateway' => 'paystack',
                    'gateway_response' => $txn
                ]
            ]);

            $count++;
        }

        $this->info("Imported $count new orders successfully.");
    }
}
