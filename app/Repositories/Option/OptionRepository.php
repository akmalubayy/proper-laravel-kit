<?php

namespace App\Repositories\Option;

use App\Models\Option;

class OptionRepository implements OptionRepositoryInterface
{
    public function optionIndex()
    {
        $option = Option::get()->first();

        return view('pages.option.index', compact(['option']));
    }

    public function optionStore($request)
    {
        // Validasi
        $request->validate([
            'sitetitle' => 'required|min:2',
            'siteurl'   => 'nullable|url|min:2',
            'homeurl'   => 'nullable|url|min:2',
            'sitelogo'  => 'nullable|image|mimes:jpeg,jpg,png|max:3000',
        ]);

        // Ambil data yang sudah ada (jika ada)
        $option = Option::first();

        // // Handle upload logo
        // $logoPath = $option?->sitelogo; // pertahankan logo lama jika tidak diupload

        // if ($request->hasFile('sitelogo')) {
        //     // Hapus logo lama jika ada
        //     if ($logoPath && Storage::disk('public')->exists($logoPath)) {
        //         Storage::disk('public')->delete($logoPath);
        //     }
        //     // Simpan logo baru
        //     $logoPath = $request->file('sitelogo')->store('logos', 'public');
        // }

        // Siapkan data input
        $data = [
            'sitetitle' => $request->sitetitle,
            'siteurl'   => $request->siteurl,
            'homeurl'   => $request->homeurl,
        ];

        // Simpan: create jika belum ada, update jika sudah ada
        if ($option) {
            $option->update($data);
            $message = 'Data berhasil diperbarui.';
        } else {
            Option::create($data);
            $message = 'Data berhasil disimpan.';
        }

        return redirect()->back()->with('sukses', $message);
    }
}
