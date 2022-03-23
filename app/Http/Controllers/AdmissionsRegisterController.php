<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\CombinationSubjects;
use App\Models\cv;
use App\Models\District;
use App\Models\Region;
use App\Models\Ward;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class AdmissionsRegisterController extends Controller
{
    //
    function showRegion()
    {

        $region = Region::get();
        return $region;
    }
    function showDistrict($id)
    {
        $district = Region::find($id)->districts;
        return $district;
    }
    function showWard($id)
    {
        $ward = District::find($id)->wards;
        return $ward;
    }
    function pdf()
    {

        $pdf = PDF::loadView('sample');
        //  return $pdf->download('sample.pdf');
        $pdf->save(public_path('sample.pdf'));
        //return $pdf->stream();
    }
    function store_test()
    {
        if (request()->thumbnail) {
            $image_64 = request()->thumbnail;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.' . $extension;
            // request()->file('thumbnail')->storeAs('public/uploads', $imageName, base64_decode($image));
            Storage::disk('public')->put($imageName, base64_decode($image));
            return;
        }


        if (request()->hasFile('thumbnail')) {
            $name = request()->file('thumbnail')->getClientOriginalName();
            // $request->file('file')->move('public/uploads',$name); // thư mục tùy chọn
            // return $request->file->store('public/uploads',$name);// dùng store nó sẽ dùng random id làm name ảnh
            request()->file('thumbnail')->storeAs('public/uploads', $name);
            $urlimg["thumbnail"] = 'storage/app/public/uploads/' . $name;
        }
        if (request()->hasFile('imgFrontCCCD')) {
            $name = request()->file('imgFrontCCCD')->getClientOriginalName();
            // $request->file('file')->move('public/uploads',$name); // thư mục tùy chọn
            // return $request->file->store('public/uploads',$name);// dùng store nó sẽ dùng random id làm name ảnh
            request()->file('imgFrontCCCD')->storeAs('public/uploads', $name);
            $urlimg["imgFrontCCCD"] = 'storage/app/public/uploads/' . $name;
        }
        if (request()->hasFile('imgBackCCCD')) {
            $name = request()->file('imgFrontCCCD')->getClientOriginalName();

            request()->file('imgBackCCCD')->storeAs('public/uploads', $name);
            $urlimg['imgBackCCCD'] = 'storage/app/public/uploads/' . $name;
        }
        if (request()->hasFile('graduate')) {
            $name = request()->file('graduate')->getClientOriginalName();

            request()->file('graduate')->storeAs('public/uploads', $name);
            $urlimg['graduate'] = 'storage/app/public/uploads/' . $name;
        }
        if (request()->hasFile('3x4')) {
            $name = request()->file('3x4')->getClientOriginalName();

            request()->file('3x4')->storeAs('public/uploads', $name);
            $urlimg["3x4"] = 'storage/app/public/uploads/' . $name;
        }
    }
    function store()
    {
        $orderId = request()->vnp_TxnRef;
        $fullname = request()->surname . " " . request()->name;
        $cccd = request()->cccd;
        $gender = request()->gender;
        $phone = request()->phone;
        $region = Region::find((request()->region));
        $district = District::find((request()->district));
        $ward = Ward::find((request()->ward));
        $tem_region = Region::find((request()->tem_region));
        $tem_district = District::find((request()->tem_district));
        $tem_ward = Ward::find((request()->tem_ward));
        $aspiration  = Aspiration::find(request()->aspiration);
        $combinationSubjects = CombinationSubjects::find(request()->subjects);
        $inforAll = array(request()->all()); // pdfdom cần 
        $urlImg = array();
        $school_name = request()->school_name;
        $data = cv::create([
            "surname" => request()->surname,
            "name" => request()->name,
            "gender" => $gender,
            "phone" => $phone,
            "cccd" => $cccd,
            "school_name" => $school_name[0],
            "birthday" => request()->birthday,
            "region" => $region->name,
            "aspiration" => request()->aspiration,
            "slug_pdf" => "public/cv-${cccd}.pdf",
            "vnp_id" => $orderId,
        ]);
        if (request()->imgFrontCCCD) {
            $image_64 = request()->imgFrontCCCD;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "imgFrontCCCD" . "-" . $data->id . '.' . $extension;
            $urlImg['imgFrontCCCD'] = $imageName;
            // request()->file('thumbnail')->storeAs('public/uploads', $imageName, base64_decode($image));
            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        if (request()->imgBackCCCD) {
            $image_64 = request()->imgBackCCCD;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "imgBackCCCD" . "-" . $data->id . '.' . $extension;
            $urlImg['imgBackCCCD'] = $imageName;
            // request()->file('thumbnail')->storeAs('public/uploads', $imageName, base64_decode($image));
            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        if (request()->graduate) {
            $image_64 = request()->graduate;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "graduate" . "-" . $data->id . '.' . $extension;
            $urlImg['graduate'] = $imageName;

            // request()->file('thumbnail')->storeAs('public/uploads', $imageName, base64_decode($image));
            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        if (request()->input('3x4')) {
            $image_64 = request()->input('3x4');
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "3x4" . "-" . $data->id . '.' . $extension;
            $urlImg['3x4'] = $imageName;
            // request()->file('thumbnail')->storeAs('public/uploads', $imageName, base64_decode($image));
            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        $pdf = PDF::loadView('sample', compact("inforAll", "urlImg", "region", "district", "ward", "tem_region", "tem_district", "tem_ward", "aspiration", "combinationSubjects"));
        $pdf->save(public_path('cv-' . $cccd . "." . "pdf",));
        return 1;
    }
    function showCvByCCCD($param)
    {

        $cv = cv::where("cccd", $param)->get();
        if (count($cv) > 0) {
            return $cv;
        } else {
            return 0;
        }
    }
    function update()
    {

        $fullname = request()->surname . " " . request()->name;
        $cccd = request()->cccd;
        $gender = request()->gender;
        $phone = request()->phone;
        $region = Region::find((request()->region));
        $district = District::find((request()->district));
        $ward = Ward::find((request()->ward));
        $tem_region = Region::find((request()->tem_region));
        $tem_district = District::find((request()->tem_district));
        $tem_ward = Ward::find((request()->tem_ward));
        $aspiration  = Aspiration::find(request()->aspiration);
        $combinationSubjects = CombinationSubjects::find(request()->subjects);
        $inforAll = array(request()->all()); // pdfdom cần 
        $urlImg = array();
        $school_name = request()->school_name;
        $data = cv::where('cccd', $cccd)->first();
        $data->update([
            "surname" => request()->surname,
            "name" => request()->name,
            "gender" => $gender,
            "phone" => $phone,
            "school_name" => $school_name[0],
            "birthday" => request()->birthday,
            "region" => $region->name,
            "aspiration" => request()->aspiration,
            "slug_pdf" => "public/cv-${cccd}.pdf",
        ]);
        if (request()->imgFrontCCCD) {
            $image_64 = request()->imgFrontCCCD;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "imgFrontCCCD" . "-" . $data->id . '.' . $extension;
            $urlImg['imgFrontCCCD'] = $imageName;
            $imageNameDelete="imgFrontCCCD" . "-" . $data->id;
            // request()->file('thumbnail')->storeAs('public/uploads', $imageName, base64_decode($image));
            Storage::disk('public')->delete(["${imageNameDelete}.png","${imageNameDelete}.jpg","${imageNameDelete}.jpeg"]);            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        if (request()->imgBackCCCD) {
            $image_64 = request()->imgBackCCCD;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "imgBackCCCD" . "-" . $data->id . '.' . $extension;
            $urlImg['imgBackCCCD'] = $imageName;
            $imageNameDelete="imgBackCCCD" . "-" . $data->id;
            // request()->file('thumbnail')->storeAs('public/uploads', $imageName, base64_decode($image));
            Storage::disk('public')->delete(["${imageNameDelete}.png","${imageNameDelete}.jpg","${imageNameDelete}.jpeg"]);
            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        if (request()->graduate) {
            $image_64 = request()->graduate;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "graduate" . "-" . $data->id . '.' . $extension;
            $urlImg['graduate'] = $imageName;
            $imageNameDelete="graduate" . "-" . $data->id;
            // request()->file('thumbnail')->storeAs('public/uploads', $imageName, base64_decode($image));
            Storage::disk('public')->delete(["${imageNameDelete}.png","${imageNameDelete}.jpg","${imageNameDelete}.jpeg"]);
            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        if (request()->input('3x4')) {
            $image_64 = request()->input('3x4');
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "3x4" . "-" . $data->id . '.' . $extension;
            $urlImg['3x4'] = $imageName;
            $imageNameDelete="3x4" . "-" . $data->id;
            // request()->file('thumbnail')->storeAs('public/uploads', $imageName, base64_decode($image));
            Storage::disk('public')->delete(["${imageNameDelete}.png","${imageNameDelete}.jpg","${imageNameDelete}.jpeg"]);            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        $pdf = PDF::loadView('sample', compact("inforAll", "urlImg", "region", "district", "ward", "tem_region", "tem_district", "tem_ward", "aspiration", "combinationSubjects"));
        $pdf->save(public_path('cv-' . $cccd . "." . "pdf",));
        return 1;
    }
}
