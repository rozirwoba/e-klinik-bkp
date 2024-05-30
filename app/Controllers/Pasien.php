<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PasienModel;

class Pasien extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->Model = new PasienModel();
        $this->Validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Pasien',
            'name' => 'pasien',
            'data_pasien' => $this->Model->findAll(),
        ];
        return view('Dashboard/pasien/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Pasien',
            'name' => 'pasien',
        ];
        return view('Dashboard/pasien/tambah', $data);
    }

    public function simpan()
    {
        $valid = $this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pasien Wajib Diisi.',
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin Wajib Diisi.',
                ]
            ],
            'gol_darah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Golongan Darah Wajib Diisi.',
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Lahir Wajib Diisi.',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Wajib Diisi.',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status Wajib Diisi.',
                ]
            ],
            'no_ktp' => [
                'rules' => 'required|numeric|is_unique[pasien.no_ktp]',
                'errors' => [
                    'required' => 'No KTP Wajib Diisi.',
                    'numeric' => 'No KTP Harus Angka',
                    'is_unique' => 'No KTP Sudah Terdaftar',
                ]
            ],
            'pekerjaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pekerjaan Wajib Diisi.',
                ]
            ],
            'bpjs' => [
                'rules' => 'numeric',
                'errors' => [
                    'numeric' => 'No BJPS Harus Angka'
                ]
            ],
            'no_tlp' => [
                'rules' => 'numeric',
                'errors' => [
                    'numeric' => 'No Telp Harus Angka'
                ]
            ],
            'image' => [
                'rules' => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[image,10240]',
                'errors' => [
                    'is_image' => 'File hanya Boleh Image',
                    'mime_in' => 'File Format Hanya Boleh jpg, jpeg, gif, png, webp',
                    'max_size' => 'Max Ukuran File 10MB',
                ]
            ],
        ]);
        
        $img = $this->request->getFile('image');
        $image = "uploads/default/default.png";
        if ($img->isValid()){
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/img/', $newName);
            $image = 'uploads/img/'.$newName;
        };

        if(!$valid) {
            return redirect()->back()->withInput()->with('errors', $this->Validation->getErrors());
        }
        $data = [
            'no_ktp' => $this->request->getVar('no_ktp'),
            'nama' => $this->request->getVar('nama'),
            'gol_darah' => $this->request->getVar('gol_darah'),
            'status' => $this->request->getVar('status'),
            'bpjs' => $this->request->getVar('bpjs'),
            'no_rm' => random_int(999, 999999),
            'image' => $image,
            'status' => $this->request->getVar('status'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_tlp' => $this->request->getVar('no_tlp'),
            'pekerjaan' => $this->request->getVar('pekerjaan'),
        ];
        $this->Model->save($data);
        return redirect()->to('Pasien/index')->with('validation', [
            'type' => 'success',
            'pesan' => 'Data <strong>'.$this->request->getVar('nama').'</strong> Berhasil Ditambahkan'
        ]);
    }

    public function update()
    {
        $valid = $this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan Wajib Diisi.',
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin Wajib Diisi.',
                ]
            ],
            'gol_darah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Golongan Darah Wajib Diisi.',
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Lahir Wajib Diisi.',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Wajib Diisi.',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status Wajib Diisi.',
                ]
            ],
            'no_ktp' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'No KTP Wajib Diisi.',
                    'numeric' => 'No KTP Harus Angka',
                    'is_unique' => 'No KTP Sudah Terdaftar',
                ]
            ],
            'pekerjaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pekerjaan Wajib Diisi.',
                ]
            ],
            'bpjs' => [
                'rules' => 'numeric',
                'errors' => [
                    'numeric' => 'No BJPS Harus Angka'
                ]
            ],
            'no_tlp' => [
                'rules' => 'numeric',
                'errors' => [
                    'numeric' => 'No Telp Harus Angka'
                ]
            ],
            'image' => [
                'rules' => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[image,10240]',
                'errors' => [
                    'uploaded' => 'File hanya Boleh Image',
                    'is_image' => 'File hanya Boleh Image',
                    'mime_in' => 'File Format Hanya Boleh jpg, jpeg, gif, png, webp',
                    'max_size' => 'Max Ukuran File 10MB',
                ]
            ],
        ]);
        $id = $this->request->getVar('id_pasien');
        $image_old = $this->request->getVar('image_old');
        $img = $this->request->getFile('image');
        $image = null;
        if(!$valid) {
            return redirect()->back()->withInput()->with('errors', $this->Validation->getErrors());
        }
        if ($img->isValid()){
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/img/', $newName);
            $image = 'uploads/img/'.$newName;
            if (file_exists($image_old)) {
                unlink($image_old);
            }
        } else {
            $image = $image_old;
        }
        $data = [
            'no_ktp' => $this->request->getVar('no_ktp'),
            'nama' => $this->request->getVar('nama'),
            'gol_darah' => $this->request->getVar('gol_darah'),
            'status' => $this->request->getVar('status'),
            'bpjs' => $this->request->getVar('bpjs'),
            'no_rm' => $this->request->getVar('no_rm'),
            'image' => $image,
            'status' => $this->request->getVar('status'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_tlp' => $this->request->getVar('no_tlp'),
            'pekerjaan' => $this->request->getVar('pekerjaan'),
        ];
        if ($this->Model->update($id, $data)) {
            return redirect()->to('Pasien/index')->with('validation', [
                'type' => 'success',
                'pesan' => 'Data <strong>'.$this->request->getVar('nama').'</strong> Berhasil Diupdate'
            ]);
        }
        return redirect()->to('Pasien/index')->with('validation', [
            'type' => 'danger',
            'pesan' => 'Data <strong>'.$this->request->getVar('nama').'</strong> Gagal Di Update'
        ]);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Pasien Edit',
            'name' => 'pasien',
            'data_pasien' => $this->Model->find($id),
        ];
        return view('Dashboard/pasien/edit', $data);
    }

    public function delete()
    {
        $kode = $this->request->getVar('kode');
        $data_pasien = $this->Model->find($kode);
        if (file_exists($data_pasien['image'])) {
            unlink($data_pasien['image']);
        }
        $response = $this->Model->where('id', $kode)->delete();
        $this->session->setFlashdata('validation', [
            'type' => 'warning',
            'pesan' => 'Pasien <strong>'. $kode . '</strong> Berhasil Dihapus'
        ]);
        return true;
    }
}