 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
		<?php
		if(isset($_SESSION['admin_id']) && $_SESSION['admin_id']!="")
		{	
				
		?>
			<li><a href="index.php"><i class="fa fa-user"></i> Members</a></li>
			<li><a href="events.php"><i class="fa fa-calendar"></i> Events</a></li>
			
		<?php
		}
		
		?>
		</ul>		
    </section>
    <!-- /.sidebar -->
  </aside>