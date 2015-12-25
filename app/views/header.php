    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>

        <div class="navbar-header pull-left">
            <a class="navbar-brand" href="index.php">易进销存</a>
        </div>

        <ul class="nav navbar-nav pull-right toolbar">
        	<li class="dropdown">
        		<a href="#" class="dropdown-toggle username" data-toggle="dropdown"><span class="hidden-xs"><?php echo $_SESSION['user_name']?> <i class="fa fa-caret-down"></i></span><img src="static/img/dangerfield.png" alt="Dangerfield" /></a>
        		<ul class="dropdown-menu userinfo arrow">
        			<li class="username">
                        <a href="#">
        				    <div class="pull-left"><img src="static/img/dangerfield.png" alt="Jeff Dangerfield"/></div>
        				    <div class="pull-right"><h5>Howdy, John!</h5><small>Logged in as <span>john275</span></small></div>
                        </a>
        			</li>
        			<li class="userlinks">
        				<ul class="dropdown-menu">
        					<li><a href="<?php echo url('Index', 'profile')?>">编辑资料 <i class="pull-right fa fa-pencil"></i></a></li>
                            <li><a href="#">帮助 <i class="pull-right fa fa-question-circle"></i></a></li>
        					<li class="divider"></li>
        					<li><a href="<?php echo url('Login', 'logout')?>" class="text-right">登出</a></li>
        				</ul>
        			</li>
        		</ul>
        	</li>
			<!--
        	<li class="dropdown">
        		<a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><i class="fa fa-envelope"></i><span class="badge">1</span></a>
        		<ul class="dropdown-menu messages arrow">
        			<li class="dd-header">
        				<span>You have 1 new message(s)</span>
        				<span><a href="#">Mark all Read</a></span>
        			</li>
                    <div class="scrollthis">
    			        <li><a href="#" class="active">
    			        	<span class="time">6 mins</span>
    			        	<img src="static/demo/avatar/doyle.png" alt="avatar" />
    			        	<div><span class="name">Alan Doyle</span><span class="msg">Please mail me the files by tonight.</span></div>
    			        </a></li>
    			        <li><a href="#">
    			        	<span class="time">12 mins</span>
    			        	<img src="static/demo/avatar/paton.png" alt="avatar" />
    			        	<div><span class="name">Polly Paton</span><span class="msg">Uploaded all the files to server. Take a look.</span></div>
    			        </a></li>
    			        <li><a href="#">
    			        	<span class="time">9 hrs</span>
    			        	<img src="static/demo/avatar/corbett.png" alt="avatar" />
    			        	<div><span class="name">Simon Corbett</span><span class="msg">I am signing off for today.</span></div>
    			        </a></li>
    			        <li><a href="#">
    			        	<span class="time">2 days</span>
    			        	<img src="static/demo/avatar/tennant.png" alt="avatar" />
    			        	<div><span class="name">David Tennant</span><span class="msg">How are you doing?</span></div>
    			        </a></li>
                        <li><a href="#">
                            <span class="time">6 mins</span>
                            <img src="static/demo/avatar/doyle.png" alt="avatar" />
                            <div><span class="name">Alan Doyle</span><span class="msg">Please mail me the files by tonight.</span></div>
                        </a></li>
                        <li><a href="#">
                            <span class="time">12 mins</span>
                            <img src="static/demo/avatar/paton.png" alt="avatar" />
                            <div><span class="name">Polly Paton</span><span class="msg">Uploaded all the files to server. Take a look.</span></div>
                        </a></li>
                    </div>
        			<li class="dd-footer"><a href="#">View All Messages</a></li>
        		</ul>
        	</li>
			-->
		</ul>
    </header>