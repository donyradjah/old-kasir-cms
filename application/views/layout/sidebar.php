<div class="sidebar-wrapper sidebar-theme">

	<nav id="sidebar">
		<div class="profile-info">
			<figure class="user-cover-image"></figure>
			<div class="user-info">
				<img src="<?= base_url() ?>/assets/img/90x90.jpg" alt="avatar">
				<h6 class=""><?= $this->session->userdata("nama") ?></h6>
			</div>
		</div>
		<div class="shadow-bottom"></div>
		<ul class="list-unstyled menu-categories" id="accordionExample">

			<li class="menu <?= $menu == "dashboard" ? "active" : "" ?>">
				<a href="<?= base_url() ?>" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<i data-feather="home"></i>
						<span>Dashboard</span>
					</div>
				</a>
			</li>

			<li class="menu <?= $menu == "kategori" ? "active" : "" ?>">
				<a href="<?= base_url("kategori") ?>" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<i data-feather="bookmark"></i>
						<span>Kategori</span>
					</div>
				</a>
			</li>
			<li class="menu <?= $menu == "produk" ? "active" : "" ?>">
				<a href="<?= base_url("produk") ?>" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<i data-feather="coffee"></i>
						<span>Produk</span>
					</div>
				</a>
			</li>
			<li class="menu <?= $menu == "transaksi" ? "active" : "" ?>">
				<a href="<?= base_url("transaksi") ?>" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<i data-feather="trello"></i>
						<span>Transaksi</span>
					</div>
				</a>
			</li>
			<li class="menu <?= $menu == "perangkat" ? "active" : "" ?>">
				<a href="<?= base_url("perangkat") ?>" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<i data-feather="smartphone"></i>
						<span>Perangkat</span>
					</div>
				</a>
			</li>
			<li class="menu <?= $menu == "user" ? "active" : "" ?>">
				<a href="<?= base_url("user") ?>" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<i data-feather="user"></i>
						<span>User</span>
					</div>
				</a>
			</li>

			<!--			<li class="menu active">-->
			<!--				<a href="#dashboard" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">-->
			<!--					<div class="">-->
			<!--						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
			<!--							 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
			<!--							 stroke-linejoin="round" class="feather feather-home">-->
			<!--							<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
			<!--							<polyline points="9 22 9 12 15 12 15 22"></polyline>-->
			<!--						</svg>-->
			<!--						<span>Dashboard</span>-->
			<!--					</div>-->
			<!--					<div>-->
			<!--						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
			<!--							 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
			<!--							 stroke-linejoin="round" class="feather feather-chevron-right">-->
			<!--							<polyline points="9 18 15 12 9 6"></polyline>-->
			<!--						</svg>-->
			<!--					</div>-->
			<!--				</a>-->
			<!--				<ul class="collapse submenu recent-submenu mini-recent-submenu list-unstyled show" id="dashboard"-->
			<!--					data-parent="#accordionExample">-->
			<!--					<li class="active">-->
			<!--						<a href="index.html"> Sales </a>-->
			<!--					</li>-->
			<!--					<li>-->
			<!--						<a href="index2.html"> Analytics </a>-->
			<!--					</li>-->
			<!--				</ul>-->
			<!--			</li>-->


			<!--			<li class="menu menu-heading">-->
			<!--				<div class="heading">-->
			<!--					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"-->
			<!--						 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"-->
			<!--						 class="feather feather-minus">-->
			<!--						<line x1="5" y1="12" x2="19" y2="12"></line>-->
			<!--					</svg>-->
			<!--					<span>USER INTERFACE</span></div>-->
			<!--			</li>-->


		</ul>

	</nav>

</div>
