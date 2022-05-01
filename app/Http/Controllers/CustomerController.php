<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Http\Resources\Customer as CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $resource = CustomerResource::collection(
            QueryBuilder::for(Customer::class)
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter([ 'name','brand', 'county', 'city'])),
                    AllowedFilter::exact('id'),
                    AllowedFilter::partial('city'),
                    AllowedFilter::partial('name'),
                    AllowedFilter::partial('manager'),
                    AllowedFilter::partial('brand'),
                    AllowedFilter::partial('county'),
                    AllowedFilter::exact('type'),
                    AllowedFilter::exact('offer'),
                    AllowedFilter::exact('can_job_order'),


                ])
                ->allowedSorts(['county', 'brand', 'offer', 'offerType', 'name', 'street', 'city', 'email', 'can_job_order'])
                ->allowedIncludes('events', 'offers')
                ->get()
        );
        return $resource;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return CustomerResource
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer->load([]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return CustomerResource
     */
    public function store(StoreCustomer $request)
    {
        $customer = Customer::create($request->all());

        $customer->save();

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return CustomerResource
     */
    public function update(UpdateCustomer $request, Customer $customer)
    {
        $customer->update($request->all());


        $customer->save();


        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();
    }

    public function importCSV(Request $request)
    {


        $file = $request->file('file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes//Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);//Where uploaded file will be stored on the server
            $location = 'uploads'; //Created an "uploads" folder for that// Upload file
            $file->move($location, $filename);// In case the uploaded file path is to be stored in the database
            $filepath = public_path($location . "/" . $filename);
// Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;
//Read the contents of the uploaded file
            while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
                $num = count($filedata);
// Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file); //Close after reading
            $j = 0;
            foreach ($importData_arr as $importData) {

                 $street = '';
                 $city= '';
                 $phone= '';
                 $phone2= '';
                 $phone3= '';
                 $prefix= '';
                 $email= '';
                 $kunr='';
                 $email2= '';
                 $brand= '';
                 $type= '';
                 $city= '';
                 $manager= '';
                 $manager_title= '';
                 $name= '';
                 $name2= '';
                 $uident= '';
                 $county= '';

                $name = utf8_encode($importData[4]); //Get user names
                $street = utf8_encode($importData[6]);
                $prefix = $importData[3];
                $city = utf8_encode($importData[8] . ' ' . $importData[9]);
                $type = 1;
                $email = $importData[55];
                $kunr = $importData[1];
                if($importData[10] != '')
                    $phone = $importData[10];
                else $phone = 123456789;

                $phone2 = $importData[12];
                $phone3 = $importData[82];

                if($importData[3] == 'Firma' || $importData[50] != '') {
                    $uident = $importData[50];
                    $type = 2;
                    $email = $importData[40];
                    $phone = $importData[10];
                    $name2 = utf8_encode($importData[5]);
                    $manager_title = $importData[16];
                    $manager = utf8_encode($importData[17]);
                    $brand = utf8_encode($importData[4]);
                    $email2 = $importData[55];
                }
                else if($importData[3] == 'Gemeinde') {
                    $type = 3;
                    $email = $importData[40];
                    $phone = $importData[10];
                    $manager_title = $importData[16];
                    $manager = utf8_encode($importData[17]);
                    $email2 = $importData[55];
                }


                $j++;
                try {
                    DB::beginTransaction();
                    Customer::create([
                        'street' => $street,
                        'city' => $city,
                        'kunr' => $kunr,
                        'phone' => $phone,
                        'phone2' => $phone2,
                        'phone3' => $phone3,
                        'prefix' => $prefix,
                        'email' => $email,
                        'email2' => $email2,
                        'brand' => $brand,
                        'type' => $type,
                        'county' => $city,
                        'uident' => $uident,
                        'manager' => $manager,
                        'manager_title' => $manager_title,
                        'name' => $name,
                        'name2' => $name2
                    ]);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            return response()->json([
                'message' => "$j records successfully uploaded"
            ]);
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }


}
