@if($announcement->isActive())
    <div style="background-color: {!! $announcement->background !!};width: 100%;font-weight:bold;text-align:center;color:white;padding:10px 0">
        {!! $announcement->message !!}
    </div>
@endif
