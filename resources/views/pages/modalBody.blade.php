<div class="view-modal modal fade" id="viewModal{{$infosection['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>{{$infosection['Name']}}</h2>
                            <hr class="star-primary">
                            <img src="{{$infosection['Pic']}}" class="img-responsive img-centered" alt="">
                            <p>{{$infosection['BeforeLinkText']}} <a href="{{$infosection['Link']}}">{{$infosection['LinkText']}}</a> {{$infosection['AfterLinkLext']}}</p>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
