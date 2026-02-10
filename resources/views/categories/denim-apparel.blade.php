<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }}</title>
    <link rel="stylesheet" href="{{ asset('project/css/denim.css') }}">
</head>

<body>

    <div class="shop">
        <strong>SHOP BY CATEGORY</strong>
    </div>

    <section>
        <div class="imgs">

            @foreach($category->subcategories as $sub)
                <div class="imgss">
                    <!-- Subcategory Image (optional DB field) -->
                    <img src="{{ asset('uploads/category/' . ($sub->images->first()->filename ?? 'default.jpg')) }}" alt="{{ $sub->name }}">

                    <!-- Subcategory Name -->
                    <p>
                        <a href="{{ route('subcategory.view', $sub->id) }}">
                            {{ $sub->name }}
                        </a>
                    </p>
                </div>
            @endforeach

        </div>
    </section>

</body>
</html>
