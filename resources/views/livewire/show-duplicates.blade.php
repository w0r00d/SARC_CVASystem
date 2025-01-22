<div>
    

<h1>Number of duplicates: </h1> 
{{ $this->cnt }}
@if($this->cnt>1)
{{$this->table}}
@else 
<h1>No duplicates found</h1>
@endif
</div>
