<div class="row">
    @php
        {{
            $i = 1;
            $count = count($data);
        }}
    @endphp
    <input type="hidden" class="form-control" value="{{$count}}" id="count" name="count" >
    @foreach($data as $antibiotic)
    @php
        {{
            $label = $antibiotic->antibiotic;
            $label = explode('_',$label)[0];
            $label = strtoupper($label);
        }}
    @endphp
    <div class="form-group col-md-3">
        <label>{{$label}}</label>
        <div class="form-control" id="{{$antibiotic->id}}" name="{{$antibiotic->id}}" >{{$antibiotic->value}}/{{$antibiotic->interpretation}}</div>
        <input type="hidden" class="form-control" value="{{$antibiotic->id}}" id="antibiotic{{$i}}" name="antibiotic{{$i}}" >
    </div>
    @php
    {{
        $i++;
    }}
    @endphp
    @endforeach
</div>