<div>
    


@if($this->cnt>1)

<h1> Number of duplicates: {{$this->cnt -1}} </h1>
{{$this->table}}
@else 
<h1>No duplicates found</h1>
@endif

</div>
