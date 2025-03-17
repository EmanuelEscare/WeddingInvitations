<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div>
        <h1>Invitaciones</h1>
        @if($invitation)
            @foreach ($invitation->guests as $guest)
                <p>{{$guest->name}}</p>
            @endforeach
        @endif
    </div>
</div>
