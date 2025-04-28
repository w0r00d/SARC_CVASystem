<div>

<div wire:loading>
<h1> Loading Results </h1>
</div>
    @if($this->changeQ)

    
    <h1> Showing Duplicates </h1>
    @if($this->cnt==1)
    No Duplicates
    @endif
    @else

    <h1> Showing Only Pending </h1>
    @endif


<div >
    {{$this->table}}
</div>
</div>
