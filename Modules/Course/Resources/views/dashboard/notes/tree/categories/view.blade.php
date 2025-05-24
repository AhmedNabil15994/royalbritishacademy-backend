@foreach ($mainCategories as $category)
<ul>
  <li id="{{$category->id}}" data-jstree='{"opened":true{{ $category->children->count() > 0?' ,"disabled":true':'' }}@if ($model->category_id ==
    $category->id),"selected":true @endif }'>
    {{$category->title}}
    @if($category->children->count() > 0)
    @include('course::dashboard.notes.tree.categories.view',['mainCategories' => $category->children])
    @endif
  </li>
</ul>
@endforeach
