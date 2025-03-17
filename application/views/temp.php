<!DOCTYPE html>
<html lang="en" class="light">
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url('assets/')?>logo.png" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="LEFT4CODE">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="<?= base_url('assets/')?>dist/css/app.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <!-- END: Head -->
    <body class="py-5 md:py-0">
        <!-- BEGIN: Top Bar -->
        <div class="top-bar-boxed h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] mt-12 md:mt-0 -mx-3 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700">
            <div class="h-full flex items-center">
                <!-- BEGIN: Logo -->
                <a href="" class="logo -intro-x hidden md:flex xl:w-[180px] block">
                    <img alt="Midone - HTML Admin Template" class="logo__image w-6" src="<?= base_url('assets/')?>logo.png">
                    <span class="logo__text text-white text-xl ml-3"> Binco App </span> 
                </a>
                <!-- END: Logo -->
                <!-- BEGIN: Breadcrumb -->
                <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
                    <ol class="breadcrumb breadcrumb-light">
                        <li class="breadcrumb-item"><a href="#">Application</a></li>
                        <li class="breadcrumb-item" aria-current="page"><?= $title ?></li>
                    </ol>
                </nav>
                <!-- END: Breadcrumb -->
                <!-- BEGIN: Account Menu -->
                <div class="intro-x dropdown w-8 h-8">
                    <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110" role="button" aria-expanded="false" data-tw-toggle="dropdown">
                        <img alt="Midone - HTML Admin Template" src="<?= base_url('assets/') ?>dist/images/profile-6.jpg">
                    </div>
                    <div class="dropdown-menu w-56">
                        <ul class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                            <li class="p-2">
                                <div class="font-medium"><?= $this->session->userdata('nama') ?></div>
                                <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500"><?= $this->session->userdata('level') ?></div>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-white/[0.08]">
                            </li>
                            <li>
                                <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profile </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-white/[0.08]">
                            </li>
                            <li>
                                <a href="<?= base_url('auth/logout') ?>" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Account Menu -->
            </div>
        </div>
        <!-- END: Top Bar -->
        <div class="flex overflow-hidden">
            <!-- BEGIN: Side Menu -->
            <?php $halaman = $this->uri->segment(2);?>
            <nav class="side-nav">
                <ul>
                    <li>
                        <a href="<?= base_url('admin/home') ?>" class="side-menu <?php if($halaman=='home'){ echo "side-menu--active"; } ?>">
                            <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="side-menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/bahan') ?>" class="side-menu <?php if($halaman=='bahan'){ echo "side-menu--active"; } ?>">
                            <div class="side-menu__icon"> <i data-lucide="command"></i> </div>
                            <div class="side-menu__title"> Daftar Bahan </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/bahanmasuk') ?>" class="side-menu <?php if($halaman=='bahanmasuk'){ echo "side-menu--active"; } ?>">
                            <div class="side-menu__icon"> <i data-lucide="skip-back"></i> </div>
                            <div class="side-menu__title"> Bahan Masuk</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/bahankeluar') ?>" class="side-menu <?php if($halaman=='bahankeluar'){ echo "side-menu--active"; } ?>">
                            <div class="side-menu__icon"> <i data-lucide="skip-forward"></i> </div>
                            <div class="side-menu__title"> Bahan Keluar</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/supplierbahan') ?>" class="side-menu <?php if($halaman=='supplierbahan'){ echo "side-menu--active"; } ?>">
                            <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="side-menu__title"> Supplier Bahan</div>
                        </a>
                    </li>

                    <li class="side-nav__devider my-6"></li>
                    <li>
                        <a href="<?= base_url('admin/pelanggan') ?>" class="side-menu <?php if($halaman=='pelanggan'){ echo "side-menu--active"; } ?>">
                            <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                            <div class="side-menu__title"> Pelanggan</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/bahan') ?>" class="side-menu <?php if($halaman=='bahan'){ echo "side-menu--active"; } ?>">
                            <div class="side-menu__icon"> <i data-lucide="command"></i> </div>
                            <div class="side-menu__title"> Pengguna </div>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div class="content">
                <?= $contents ?>
                
            </div>
            <!-- END: Content -->
        </div>
        <!-- BEGIN: JS Assets-->
        <script src="<?= base_url('assets/')?>dist/js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script>
            $('#example1').DataTable({
                "searching": true,
                "lengthChange": false,
                "language": {
                    "search": "Pencarian "
                }
            });
            $('#example2').DataTable({
                "searching": true,
                "lengthChange": false,
                "language": {
                    "search": "Pencarian "
                }
            });
            $('#log').DataTable({
                "searching": false,
                "lengthChange": false,
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            <?php if($this->session->flashdata('notifikasi')): ?>
                Swal.fire({
                    icon: '<?= $this->session->flashdata('icon') ?>',
                    text: '<?= $this->session->flashdata('notifikasi') ?>',
                    confirmButtonColor: '#28a745' // Warna hijau untuk tombol "OK"
                });
            <?php endif; ?>
        </script>
        <?php $this->session->unset_userdata('icon'); $this->session->unset_userdata('notifikasi');?>
            <!-- END: JS Assets-->
    </body>
</html>