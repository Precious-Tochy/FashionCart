@extends('layouts.user layout')

@section('content')
<div class="contact-container">
    <h1>Contact Us</h1>
    <p>We’d love to hear from you! Reach out to us via email, phone, or our contact form below.</p>

    <div class="contact-cards">
        <div class="contact-card">
            <i class="ri-mail-line"></i>
            <h3>Email</h3>
            <p>preciousabugu38@gmail.com</p>
        </div>

        <div class="contact-card">
            <i class="ri-phone-line"></i>
            <h3>Phone</h3>
            <p>+234 905 353 1176</p>
        </div>

        <div class="contact-card">
            <i class="ri-map-pin-line"></i>
            <h3>Address</h3>
            <p>Anambra, Nigeria</p>
        </div>
    </div>
</div>

<style>
/* GENERAL */
.contact-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
    font-family: 'Poppins', sans-serif;
    color: #333;
}

.contact-container h1 {
    text-align: center;
    font-size: 36px;
    color: #ae5a8d;
    margin-bottom: 10px;
}

.contact-container p {
    text-align: center;
    font-size: 16px;
    margin-bottom: 30px;
}

/* CARDS */
.contact-cards {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 25px;
}

.contact-card {
    flex: 1 1 calc(33.3% - 20px);
    min-width: 260px;
    background: #fff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-5px);
}

.contact-card i {
    font-size: 40px;
    color: #ae5a8d;
    margin-bottom: 12px;
}

.contact-card h3 {
    font-size: 20px;
    margin-bottom: 8px;
    font-weight: 600;
}

.contact-card p {
    font-size: 15px;
    color: #555;
}

/* TABLET (iPad) VIEW */
@media (max-width: 992px) {
    .contact-cards {
        justify-content: center;
    }

    .contact-card {
        flex: 1 1 calc(45% - 20px);
    }

    .contact-container h1 {
        font-size: 32px;
    }
}

/* PHONE VIEW */
@media (max-width: 600px) {
    .contact-card {
        flex: 1 1 100%;
    }

    .contact-container h1 {
        font-size: 28px;
    }

    .contact-card i {
        font-size: 35px;
    }
}
</style>
@endsection
