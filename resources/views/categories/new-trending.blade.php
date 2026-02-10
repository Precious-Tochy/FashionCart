<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }}</title>
    <link rel="stylesheet" href="{{ asset('project/css/new.css') }}">
</head>
<body>
    <div class="me">
        <div class="shops">

            <!-- Subcategories List -->
            <div class="shop">
                <strong>SHOP BY CATEGORY</strong>
                <ul>
                    @foreach($category->subcategories as $sub)
                        <li>
                            <a href="{{ route('subcategory.view', $sub->id) }}">
                                {{ $sub->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Subcategory Images -->
            <div class="wings">
                <div class="imt">
                    @foreach($category->subcategories as $sub)
                        @foreach($sub->images as $image)
                            <img src="{{ asset('uploads/category/' . $image->filename) }}" alt="{{ $sub->name }}">
                        @endforeach
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</body>
</html>
