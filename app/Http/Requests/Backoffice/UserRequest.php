<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $pengguna_id = $this->request->get('pengguna_id') ? ',' . $this->request->get('pengguna_id') . ',pengguna_id' : '';

        return [
            'pengguna_id' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'pengguna_id.required' => 'Nama Lengkap tidak boleh kosong',
        ];
    }
}
