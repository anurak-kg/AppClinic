<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use Redirect;
use Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $settingList = [
        'clinicName'        => 'required',
        'commission_rate'   => 'required',
        'vat_mode'          => 'required',
        'vat_rate'          => 'required',
        'product_day_expire' => 'required',
        'order_sell'        => 'required',
        'customer_photo_limit'        => 'required',

    ];

    public function getIndex()
    {
        $setting = new Setting($this->settingList);
        $setting->initSettingList($this->settingList);
        $value = $setting->getSettingValue();
        //dd($value);

        return view('setting.setting', compact(['value']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function postSave()
    {

        $validator = Validator::make(Input::all(), $this->settingList);
        if ($validator->fails()) {

            $messages = $validator->messages();

            return Redirect::to('setting')
                ->withErrors($validator);

        } else {
            $setting = new Setting();
            $input = Input::except('_token');
            $setting->save($input);
            //dd($input);

            return redirect('setting')->with('message','ลงบันทึกเรียบร้อยแล้ว');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
