<?php
 $is_judge = Auth::user()->hasRole('judge');
?>
<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="pull-right">
        <button class="hamburger btn-link is-active"><span class="hamburger-inner"></span></button>
        </div>
        @if($is_judge)
        <ul class="nav navbar-nav">
            <li>
              <a href="{{route('voyager.judge-polls.create')}}" target="_self">
                    <span class="icon voyager-check"></span>
                    <span class="title">Голосование</span>
                </a>
            </li>
        </ul>
        @else
         {!! menu('admin', 'admin_menu') !!}
        @endif
    </nav>
</div>
