<?= $this->extend('Dashboard/layout') ?>

<?= $this->section('content') ?>
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
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">
                            <main class="app-main">
                                <div class="container">
                                    <a href="<?= base_url('RawatInap/index') ?>"
                                    class="btn btn-warning">Kembali</a>
                                </div>
                                <div class="app-content container py-5">
                                    <div class="card card-primary card-outline mb-4">
                                        <div class="card-header">
                                            <div class="card-title">Data
                                                <strong><?= $data['data_pasien']['nama'] ?></strong>
                                            </div>
                                        </div>
                                        <form action="<?= base_url('RawatInap/update') ?>" method="POST" enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <input type="hidden" class="form-control" name="id_rawat_inap" id="id_rawat_inap" value="<?= $data['data_rawat_inap']['id'] ?>">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="pasien" class="form-label">Pilih Pasien</label>
                                                    <select name="pasien" id="pasien" class="form-control <?= session('errors.pasien') ? 'is-invalid' : '' ?>">
                                                        <option value="">Nama Pasien | No. RM</option>
                                                        <?php
                                                            foreach ($data['data_semua_pasien'] as $key => $value) {
                                                        ?>
                                                            <option value="<?= $value['id'] ?>" <?= ($data['data_pasien']['id'] == $value['id']) ? 'selected' : '' ?>><?= $value['nama'] ?> | <?= $value['no_rm'] ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= session('errors.pasien') ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal" class="form-label">Tanggal Masuk</label>
                                                    <input type="date"
                                                        class="form-control <?= session('errors.tanggal') ? 'is-invalid' : '' ?>"
                                                        name="tanggal" id="tanggal" value="<?= $data['data_rawat_inap']['tgl_masuk'] ?>">
                                                    <div class="invalid-feedback">
                                                        <?= session('errors.tanggal') ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jam" class="form-label">Jam Masuk</label>
                                                    <input type="time"
                                                        class="form-control <?= session('errors.jam') ? 'is-invalid' : '' ?>"
                                                        name="jam" id="jam" value="<?= $data['data_rawat_inap']['jam_masuk'] ?>">
                                                    <div class="invalid-feedback">
                                                        <?= session('errors.jam') ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="keluhan" class="form-label">Keluhan</label>
                                                    <input type="text" class="form-control <?= session('errors.keluhan') ? 'is-invalid' : '' ?>" name="keluhan" id="keluhan" value="<?= $data['data_rawat_inap']['keluhan'] ?>">
                                                    <div class="invalid-feedback">
                                                        <?= session('errors.keluhan') ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="type" class="form-label">Type Faskes</label>
                                                    <select name="type" id="type" class="form-control <?= session('errors.type') ? 'is-invalid' : '' ?>">
                                                        <option value="">Pilih Type</option>
                                                        <option value="Umum" <?= ($data['data_rawat_inap']['type'] == 'Umum') ? 'selected' : '' ?>>Umum</option>
                                                        <option value="BPJS" <?= ($data['data_rawat_inap']['type'] == 'BPJS') ? 'selected' : '' ?>>BPJS</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= session('errors.type') ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kamar" class="form-label">Kamar</label>
                                                    <select name="kamar" id="kamar" class="form-control <?= session('errors.kamar') ? 'is-invalid' : '' ?>">
                                                        <option value="">Pilih Kamar</option>
                                                        <?php
                                                            foreach ($data['data_semua_kamar'] as $key => $value) {
                                                        ?>
                                                            <option value="<?= $value['id'] ?>" <?= ($data['data_rawat_inap']['id_kamar'] == $value['id']) ? 'selected' : '' ?>><?= $value['nama'] . ' | '. $value['kelas'] ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= session('errors.kamar') ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dokter" class="form-label">Dokter</label>
                                                    <select name="dokter" id="dokter" class="form-control <?= session('errors.dokter') ? 'is-invalid' : '' ?>">
                                                        <option value="">Pilih Dokter</option>
                                                        <?php
                                                            foreach ($data['data_semua_dokter'] as $key => $value) {
                                                        ?>
                                                            <option value="<?= $value['id'] ?>" <?= ($data['data_rawat_inap']['id_dokter'] == $value['id']) ? 'selected' : '' ?>><?= $value['nama'] ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?= session('errors.dokter') ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>