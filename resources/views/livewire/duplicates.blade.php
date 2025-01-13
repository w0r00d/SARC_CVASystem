<div>
    {{-- In work, do what you enjoy. --}}

    @if($this->changeQ)

    <h1> Showing Only Pending </h1>

    @else

    <h1> Showing Duplicates </h1>

    @endif

    {{$this->table}}
</div>
