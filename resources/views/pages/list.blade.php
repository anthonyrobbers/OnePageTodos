@extends('layout')

@section('Title')
Shadowed Universe Information
@stop

@section('content')
{!! view('pages.navigation',['title'=>'Shadowed Universe','sections'=>['view','about']]) !!} 
    

    {!! view('pages.Header',['img'=> 'img/SU/CampaignLogo.jpg','title'=> 'Shadowed Universe Information','info'=> 'A place to put all the information on the shadowed universe.  Look here for Character pages, Session summaries, Logs, and other information about the shadowed universe campaign.']) !!}
    {!! view('pages.SectionOpen',['id'=>'view','class'=>NULL]) !!}
    <!-- view Grid Section -->
    
        @foreach ($infosections as $infosection)

            {!!view('pages.modal',['modalNumber'=> $infosection['id'], 'modalPic'=>$infosection['Pic']])!!}
        @endforeach
    {!! view('pages.SectionClose') !!}

    <!-- About Section -->
    {!! view('pages.SectionOpen',['id'=>'about', 'class'=>'success']) !!}
        <div class="col-lg-4 col-lg-offset-2">
            <p>The Shadowed Universe (add a campaign summary here)</p><!-- change needed: add a campaign summary  and a party summary-->
        </div>
        <div class="col-lg-4">
            <p>The current party, named privately as Last Resort Inc. is composed of ______</p>
        </div>
    {!!view('pages.SectionClose')!!}
     
    {!! view('pages.Footer', ['buttonlist'=>['button' =>'https://www.dropbox.com/sh/t8kqurzu7znmc47/AACjAvVrUJMI5LgI1hnMQp4ra?dl=0" class="btn-social btn-outline"><i class="fa fa-fw fa-dropbox']]) !!}
    
    <!-- view Modals -->
     @foreach ($infosections as $infosection)
            {!!view('pages.modalBody', compact('infosection'))!!}
            @endforeach
    
    
    
    @stop
    
