<h1>{{ $category->name }}</h1>
<ul>
@foreach($category->subcategories as $sub)
    <li>{{ $sub->name }}</li>
@endforeach
</ul>
