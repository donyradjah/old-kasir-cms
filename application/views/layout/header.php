<div class="header-container fixed-top">
	<header class="header navbar navbar-expand-sm">

		<ul class="navbar-nav theme-brand flex-row  text-center">
			<li class="nav-item theme-logo">
				<a href="<?= base_url() ?>">
					<img src="<?= base_url() ?>/assets/img/90x90.jpg" class="navbar-logo" alt="logo">
				</a>
			</li>
			<li class="nav-item theme-text">
				<a href="<?= base_url() ?>" class="nav-link"> POS </a>
			</li>
			<li class="nav-item toggle-sidebar">
				<a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
					<i data-feather="list"></i>
				</a>
			</li>
		</ul>

		<ul class="navbar-item flex-row navbar-dropdown">

		</ul>

		<ul class="navbar-item flex-row search-ul">

		</ul>
		<ul class="navbar-item flex-row navbar-dropdown">

			<li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
				<a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
				   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i data-feather="user"></i>
				</a>
				<div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="userProfileDropdown">
					<div class="user-profile-section">
						<div class="media mx-auto">
							<img src="<?= base_url() ?>/assets/img/90x90.jpg" class="img-fluid mr-2" alt="avatar">
							<div class="media-body">
								<h5><?= $this->session->userdata("nama") ?></h5>
							</div>
						</div>
					</div>
					<div class="dropdown-item">
						<a href="<?= base_url("user/ubah/" . $this->session->userdata("idUser")) ?>">
							<i data-feather="user"></i>
							<span>My Profile</span>
						</a>
					</div>

					<div class="dropdown-item">
						<a href="<?= base_url("logout") ?>">
							<i data-feather="log-out"></i>
							<span>Log Out</span>
						</a>
					</div>
				</div>
			</li>
		</ul>
	</header>
</div>
