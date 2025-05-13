<div class="border p-3 mb-3">
    <div class="mb-2">
        <label>Jenis Soal</label>
        <select name="questions[{{ $index }}][type]" class="form-control" required>
            <option value="fill_blank">Fill in the Blank</option>
            <option value="meaning_choice">Pilih Arti</option>
            <option value="jp_choice">Pilih Kalimat Jepang</option>
        </select>
    </div>

    <div class="mb-2">
        <label>Pertanyaan</label>
        <input type="text" name="questions[{{ $index }}][question]" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Pilihan Jawaban (pisahkan dengan koma)</label>
        <input type="text" name="questions[{{ $index }}][options]" class="form-control" placeholder="contoh1, contoh2, contoh3" required>
    </div>

    <div class="mb-2">
        <label>Jawaban Benar (harus sama persis dengan salah satu pilihan)</label>
        <input type="text" name="questions[{{ $index }}][correct_answer]" class="form-control" required>
    </div>
</div>
