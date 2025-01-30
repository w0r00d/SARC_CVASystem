<div>
    
<h1> HEADING: {{$this->test }} </h1>

@if($this->cnt>1)

<h1> Number of duplicates: {{$this->cnt -1}} </h1>
{{$this->table}}
@else 
<h1>No duplicates found</h1>
@endif

</div>
