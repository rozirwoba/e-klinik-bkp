<?= $this->extend('Dashboard/layout') ?>
<?= $this->section('content') ?>
<?php
            function FormatDate($tanggal) {
                // Array bulan dalam bahasa Indonesia
                $bulanIndonesia = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember'
                ];
            
                // Cek apakah tanggal valid
                $date = DateTime::createFromFormat('Y-m-d', $tanggal);
                if (!$date) {
                    $date = DateTime::createFromFormat('d/m/Y', $tanggal);
                }
                if (!$date) {
                    $date = DateTime::createFromFormat('d-m-Y', $tanggal);
                }
                if (!$date) {
                    $date = DateTime::createFromFormat('m/d/Y', $tanggal);
                }
                if (!$date) {
                    $date = DateTime::createFromFormat('m-d-Y', $tanggal);
                }
            
                // Jika format tanggal tidak sesuai
                if (!$date) {
                    return "Format tanggal tidak valid";
                }
            
                // Ambil bagian-bagian dari tanggal
                $hari = $date->format('d');
                $bulan = $date->format('n'); // Mengembalikan angka bulan tanpa leading zero
                $tahun = $date->format('Y');
            
                // Format ke dalam bahasa Indonesia
                return $hari . ' ' . $bulanIndonesia[$bulan] . ' ' . $tahun;
            }
        ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= $title ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $title ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm">
                                    <a href="<?= base_url('Laporan/PeminjamanstatusRI/exportCSV') ?>"
                                        class="btn btn-success">
                                        <i class="fa-solid fa-file-csv" style="padding-right: 5px"></i> Export CSV
                                    </a>
                                </div>
                                <div class="col-sm-2 pt-1">
                                    <input type="date" id="dateFilter" class="form-control me-2"
                                        onchange="filterTableByDate()" placeholder="Filter by Tanggal Masuk">
                                </div>
                            </div>
                        </div>

                        <div class="container py-3">
                            <?php 
                                if (!empty(session('errors'))) {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <ol>
                                    <?php 
                                        foreach (session('errors') as $key => $value) {
                                    ?>
                                    <li><?= $value ?></li>
                                    <?php 
                                        }
                                    ?>
                                </ol>
                            </div>
                            <?php 
                                }
                            ?>

                            <?php 
                                if (!empty(session('validation')['type'])) {
                            ?>
                            <div class="alert alert-<?= session('validation')['type'] ?>" role="alert">
                                <?= session('validation')['pesan'] ?>
                            </div>
                            <?php 
                                }
                            ?>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 4%;">No</th>
                                        <!-- <th>Foto</th> -->
                                        <th>No. RM</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Kamar</th>
                                        <th>Diagnosa</th>
                                        <th>Dokter</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal keluar</th>
                                    </tr>
                                </thead>
                                <tbody id="dataTable">
                                    <?php
                                        if (!empty($data)) {
                                            $no = 1;
                                            foreach ($data as $key => $value) {
                                    ?>
                                    <tr class="align-middle text-center">
                                        <td style="width: 4%; text-align: center;"><?= $no++ ?></td>
                                        <!-- <td class="d-flex justify-content-center">
                                            <div class="image-profile-container">
                                                <img src=""
                                                    alt="Profile">
                                            </div>
                                        </td> -->
                                        <td><?= $value['data_pasien']['no_rm'] ?></td>
                                        <td><?= $value['data_pasien']['nama'] ?></td>
                                        <td><?= $value['data_pasien']['alamat'] ?></td>
                                        <td><?= $value['data_kamar']['nama'] ?></td>
                                        <td><?= $value['data_laporan']['keluhan'] ?></td>
                                        <td><?= $value['data_dokter']['nama'] ?></td>
                                        <td>
                                            <div class="text-center" style="color: black;">
                                                <i class="fa-solid fa-clock"></i>
                                            </div>
                                            <?= FormatDate($value['data_laporan']['tanggal_masuk']) . ' | ' . $value['data_laporan']['jam_masuk'] ?>
                                        </td>
                                        <?php
                                            if ($value['data_laporan']['tanggal_keluar'] != null) {
                                        ?>
                                        <td>
                                            <div class="text-center" style="color: green;">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </div>
                                            <?= FormatDate($value['data_laporan']['tanggal_keluar']) . ' | ' . $value['data_laporan']['jam_keluar'] ?>
                                        </td>
                                        <?php
                                            } else {
                                        ?>
                                        <td>
                                            <p>Belum Pulang</p>
                                            <button
                                                onclick="pulangkan('<?= $value['data_laporan']['id'] ?>', '<?= $value['data_pasien']['nama'] ?>')"
                                                class="btn btn-primary">Pulangkan</button>
                                        </td>
                                        <?php
                                            }
                                        ?>
                                    </tr>
                                    <?php
                                            }
                                        } else {
                                    ?>
                                    <tr class="align-middle">
                                        <td colspan='12' style="width: 4%; text-align: center; padding-top: 10px">
                                            <h5><strong>Tidak Ada Data</strong></h5>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function filterTableByDate() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("dateFilter");
    filter = new Date(input.value);
    if (!isNaN(filter)) {
        var options = { day: 'numeric', month: 'long', year: 'numeric', locale: 'id-ID' };
        var formattedDate = filter.toLocaleDateString('id-ID', options);
    } else {
        formattedDate = "";
    }
    
    table = document.getElementById("dataTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[7];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.includes(formattedDate)) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function pulangkan(id, nama) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: "Apakah Yakin?",
        text: "Apkah Kamu Yakin Ingin Menghapus Data " + nama,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yakin",
        cancelButtonText: "Tidak",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('RawatInap/pulangkan') ?>',
                type: 'POST',
                data: {
                    kode: id,
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    swalWithBootstrapButtons.fire({
                        title: "Dibatalkan",
                        text: "No Pendafataran " + nama + ' Gagal Pulangkan',
                        icon: "error"
                    });
                }
            });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: "Dibatalkan",
                text: "No Pendafataran " + nama + ' Gagal Dihapus',
                icon: "error"
            });
        }
    });
}
</script>
<?= $this->endSection() ?>