<?php if (isset($detail_barang)): ?>
    <?php foreach ($detail_barang as $row): ?>
        <div class="form-group">
            <label>Harga</label>
            <input type="text" readonly class="form-control" value="Rp. <?= number_format($row->harga) ?>" required>
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="text" readonly class="form-control" value="<?= $row->stok ?>" required>
        </div>

        <div class="form-group">
            <label>Qty</label>
            <input name="qty" class="form-control" type="number" placeholder="Qty ..." required>
        </div>

        <input type="hidden" name="id_barang" value="<?= $row->id ?>" required>
    <?php endforeach; ?>
<?php endif; ?>