<!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title"><?= $title ?></h4>
                            </div>
                            <div class="card-body mt-2">
                                <form action="<?= base_url('laporan/index') ?>" method="POST" target="_blank">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            
                                            <div class="form-group">
                                                <strong>Pilih Bulan:</strong>
                                                <select name="bulan" id="bulan" class="form-control">
                                                    <?php $bulan_sekarang = date('m'); if(count($bulan) > 0): foreach($bulan as $value): ?>
                                                        <option value="<?= $value['id'] ?>" <?= $bulan_sekarang == $value['id'] ? 'selected' : '' ?>><?= $value['nama'] ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('bulan') ?></small>
                                            </div>
                                            <div class="form-group">
                                                <strong>Pilih Tahun:</strong>
                                                <select name="tahun" id="tahun" class="form-control">
                                                    <?php $tahun_sekarang = date('Y'); $tahun_limit = $tahun_sekarang; $tahun_akhir = $tahun_sekarang - 10; 
                                                        for($tahun = $tahun_akhir; $tahun <= $tahun_limit; $tahun++): ?>
                                                        <option value="<?= $tahun ?>" <?= $tahun == $tahun_sekarang ? 'selected' : '' ?>><?= $tahun?></option>
                                                    <?php endfor; ?>
                                                    </select>
                                                    <small class="text-danger"><?= form_error('tahun') ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary col-md-12">Pilih</button>
                                        </div>
                                    </div>    
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

   
