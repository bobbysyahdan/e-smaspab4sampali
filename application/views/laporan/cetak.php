<table border="1"> 
    <thead>
        <tr>
            <th>No.</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Kode Pembayaran</th>
            <th>Jumlah Pembayaran</th>
            <th>Tanggal Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(count($transaksi_pembayaran_spp) > 0):
            foreach($transaksi_pembayaran_spp as $key => $value): 
        ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= $value['nis'] ?></td>
            <td><?= $value['nama_siswa'] ?></td>
            <td><?= $value['nama_kelas'].' - '.$value['tahun_ajaran'] ?></td>
            <td><?= $value['kode_pembayaran'] ?></td>
            <td><?= $value['jumlah_pembayaran'] ?></td>
            <td><?= $value['tanggal_pembayaran'] ?></td>
        </tr>
        <?php 
            endforeach; 
            endif;
        ?>
    </tbody>
</table>