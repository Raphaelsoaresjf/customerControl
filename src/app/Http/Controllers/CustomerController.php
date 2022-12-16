<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerController extends Controller
{
   public function __construct()
   {
    
   }

   public function getByIdCustomer($id)
   {
        return Customer::findOrFail($id);
   }

   public function createCustomer(Request $request)
   {

        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required|max:14|min:6',
            'cpf' => 'required|size:11',
            'licensePlate' => 'required|size:7'
        ]);

        $customer = new Customer;

        $customer->name = $request->input('name');
        $customer->phone = $request->input('phone');
        $customer->cpf = $request->input('cpf');
        $customer->licensePlate = $request->input('licensePlate');

        $customer->save();

        return response()->json($customer);

   }

   public function updateCustomer($id, Request $request)
   {
        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required|max:14|min:6',
            'cpf' => 'required|size:11',
            'licensePlate' => 'required|size:7'
        ]);

        $customer = Customer::findOrFail($id);

        $customer->name = $request->input('name');
        $customer->phone = $request->input('phone');
        $customer->cpf = $request->input('cpf');
        $customer->licensePlate = $request->input('licensePlate');

        $customer->save();

        return response()->json($customer);
   }

   public function deleteCustomer($id)
   {
        try {
            $resp = Customer::findOrFail($id)->delete();
            return response(['status' => $resp, "menssagem" => "Dados do cliente deletado!"], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(["status" => "Erro", "menssagem" => $e->getMessage()], 400);
        }
   }

   public function getByFinalLicensePlateCustomer($numero)
   {
        return response()->json(Customer::where('licensePlate','like', '%'.$numero)->get());
   }


}
