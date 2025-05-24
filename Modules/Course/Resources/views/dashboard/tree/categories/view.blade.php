

@foreach ($mainCategories as $category)
<ul>
	<li id="{{$category->id}}" data-jstree=
        '{"opened":true
        {{ ($model->categories->contains($category->id)) ? ',"selected":true' : ''  }}
        }'
     >
		{{$category->title}}
		@if($category->children->count() > 0)
				@include('course::dashboard.tree.categories.view',['mainCategories' => $category->children])
		@endif
	</li>
</ul>
@endforeach
