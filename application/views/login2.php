<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Binco Ran Nusantara</title>
    <link href="<?= base_url('assets/')?>logo.png" rel="shortcut icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-blue-900">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-orange-500 flex items-center justify-center space-x-2">
            <img class="w-12" src="<?= base_url('assets/')?>logo.png">    
            <span> Binco Ran Nusantara</span>
        </h2>
        <form action="<?= base_url('auth/login') ?>" method="POST">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="username" id="username" name="username" required class="w-full p-2 mt-1 border rounded-md focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="w-full p-2 mt-1 border rounded-md focus:ring-orange-500 focus:border-orange-500">
            </div>
            <button type="submit" class="w-full p-2 mt-5 font-bold text-white bg-orange-500 rounded-md hover:bg-orange-600">Login</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
</body>
</html>