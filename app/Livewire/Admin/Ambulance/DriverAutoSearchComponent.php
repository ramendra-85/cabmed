<?php

namespace App\Livewire\Admin\Ambulance;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class DriverAutoSearchComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$checkbookingEmergency,$check_for,$selectedbookingStatus,$selectedBookingType,
    $activeTab;

    public $isOpen = 0;
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $partner_filter = '';
 
    #[Layout('livewire.admin.layouts.base')]    //......... add the layout dynamically for the all ...........//
    

    public function resetFilters(){
          
        $this->consumer_status=null;
        $this->selectedDate=null;
        $this->search = '';
        $this->selectedFromDate = '';
        $this->selectedToDate = '';

    }

    public function filterCondition($value){
        $this->resetFilters();

            if($value=='All'){            
            $this->activeTab=$value;
        }
    
        elseif($value=='ConsumerEmergency'){
            $this->activeTab=$value;
        }
        elseif($value=='DriverEmergency'){
            $this->activeTab=$value;
        }
        elseif($value=='airAmbulance'){
            $this->activeTab=$value;
        }elseif($value=='driverAutosearch'){
            $this->activeTab=$value;
        }elseif($value=='') {
            
        }
       
}
    public function render()
    {
        if($this->activeTab =='ConsumerEmergency'){
         
            $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
            $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
            
            if($this->selectedDate == 'custom'){
                $this->selectedFromDate;
                $this->selectedToDate;
            }else{
                $this->selectedFromDate ='';
                $this->selectedToDate =''; 
            }
         
            switch ($this->selectedDate) {
                case 'all':
                    $fromDate = null;
                    $toDate = null;
                    break;
                case 'today':
                    $fromDate = Carbon::today();
                    $toDate = Carbon::today()->endOfDay();
                    break;
                case 'yesterday':
                    $fromDate = Carbon::yesterday();
                    $toDate = Carbon::yesterday()->endOfDay();
                    break;
                case 'thisWeek':
                    $fromDate = Carbon::now()->subDays(7)->startOfDay();
                    $toDate = Carbon::now();
                    break;
                case 'thisMonth':
                    $fromDate = Carbon::now()->startOfMonth();
                    $toDate = Carbon::now()->endOfMonth();
                    break;
                default:
                    $fromDate = $fromDate;
                    $toDate = $toDate;
                    break;
            }

            $consumer_list = DB::table('consumer_emergency')
            ->leftjoin('consumer', 'consumer_emergency.consumer_emergency_consumer_id', '=','consumer.consumer_id')
            ->leftjoin('booking_view', 'consumer_emergency.consumer_emergency_booking_id', '=', 'booking_view.booking_id')
            ->leftJoin('remark_data', 'remark_data.remark_consumer_emeregncy_id', '=', 'consumer_emergency.consumer_emergency_consumer_id')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('consumer_emergency.created_at', [$fromDate, $toDate]);
            }) 
            ->where(function ($query) {
                $query->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('consumer.consumer_mobile_no', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('consumer_emergency.consumer_emergency_id')
            ->paginate(10);
    
            $buket_map_data = [];
    
            foreach($consumer_list as $location_data){
                $add_data['consumer_emergency_consumer_lat'] = $location_data->consumer_emergency_consumer_lat;
                $add_data['consumer_emergency_consumer_long'] = $location_data->consumer_emergency_consumer_long;
                $add_data['consumer_name'] = $location_data->consumer_name;
                $add_data['consumer_mobile_no'] = $location_data->consumer_mobile_no;
                $unix_time = $location_data->consumer_emergency_request_timing; 
    
                $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                $normalDateTime = $carbonDateTime->toDateTimeString();
                // $data = $convertedDates;
                $currentDateTime = Carbon::now();  
                $carbonDate = Carbon::parse($normalDateTime);
                $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                $daysDifference = $carbonDate->diffInDays($currentDateTime);
                // Format the date difference as a human-readable message
                $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
    
                array_push($buket_map_data, $add_data);
            }

            if($this->check_for == 'custom'){
                return view('livewire.admin.ambulance.booking-emergency-component',[
                    'isCustom' => true
                ],compact('buket_map_data', 'consumer_list'));
            }
            return view('livewire.admin.ambulance.booking-emergency-component',[
                'isCustom' => false
            ],compact('buket_map_data', 'consumer_list'));

           
    }
    
    elseif($this->activeTab =='airAmbulance'){

        $selectedbookingStatus = $this->selectedbookingStatus ? $this->selectedbookingStatus : null;
        $selectedBookingType = $this->selectedBookingType ? $this->selectedBookingType : null;
        $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
        $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
        
        if($this->selectedDate == 'custom'){
            $this->selectedFromDate;
            $this->selectedToDate;
        }else{
            $this->selectedFromDate ='';
            $this->selectedToDate =''; 
        }
     
        switch ($this->selectedDate) {
            case 'all':
                $fromDate = null;
                $toDate = null;
                break;
            case 'today':
                $fromDate = Carbon::today();
                $toDate = Carbon::today()->endOfDay();
                break;
            case 'yesterday':
                $fromDate = Carbon::yesterday();
                $toDate = Carbon::yesterday()->endOfDay();
                break;
            case 'thisWeek':
                $fromDate = Carbon::now()->subDays(7)->startOfDay();
                $toDate = Carbon::now();
                break;
            case 'thisMonth':
                $fromDate = Carbon::now()->startOfMonth();
                $toDate = Carbon::now()->endOfMonth();
                break;
            default:
                $fromDate = $fromDate;
                $toDate = $toDate;
                break;
        }
       

        $data['airAmbulanceData'] = DB::table('air_booking_view')
                                ->leftjoin('air_ambulance_patient', 'air_booking_view.air_booking_view_id', '=', 'air_ambulance_patient.patient_bid')
                                ->leftJoin('remark_data', 'remark_data.remark_airbooking_id', '=', 'air_booking_view.air_booking_view_id')
                                ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')
                                ->select('air_booking_view.created_at','air_booking_view.*','remark_data.*','admin.*','air_ambulance_patient.patient_name','air_ambulance_patient.patient_mobile_no','air_ambulance_patient.patient_gender')
                                ->where(function ($query) {
                                    $query->where('air_booking_view.air_booking_con_name', 'like', '%' . $this->search . '%')
                                        ->orWhere('air_booking_view.air_booking_con_mobile', 'like', '%' . $this->search . '%');
                                })
                                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                                    return $query->whereBetween('air_booking_view.created_at', [$fromDate, $toDate]);
                                }) 
                                ->when($selectedbookingStatus == 'All', function ($query) use ($selectedbookingStatus) {
                                    return $query
                                        ->whereIn('air_booking_view.air_booking_status', [1,0,2,3,4,5]);
                                })
                                ->when($selectedbookingStatus == 'Enquiry', function ($query) use ($selectedbookingStatus) {
                                    return $query
                                        ->where('air_booking_view.air_booking_status',0);
                                })
                                ->when($selectedbookingStatus == 'New', function ($query) use ($selectedbookingStatus) {
                                    return $query
                                        ->where('air_booking_view.air_booking_status',1);
                                })
                                ->when($selectedbookingStatus == 'Ongoing', function ($query) use ($selectedbookingStatus) {
                                    return $query
                                        ->where('air_booking_view.air_booking_status',2);
                                })
                                ->when($selectedbookingStatus == 'Invoice', function ($query) use ($selectedbookingStatus) {
                                    return $query
                                        ->where('air_booking_view.air_booking_status',3);
                                })
                                ->when($selectedbookingStatus == 'Complete', function ($query) use ($selectedbookingStatus) {
                                    return $query
                                        ->where('air_booking_view.air_booking_status',4);
                                })
                                ->when($selectedbookingStatus == 'Cancel', function ($query) use ($selectedbookingStatus) {
                                    return $query
                                        ->where('air_booking_view.air_booking_status',5);
                                })
                                ->orderBy('air_booking_view.air_booking_view_id', 'desc')
                                ->paginate(10);


        if($this->check_for == 'custom'){
            return view('livewire.admin.ambulance.ambulance-booking-component',$data,[
                'isCustom' => true
            ]);
        }
        return view('livewire.admin.ambulance.ambulance-booking-component',$data,[
            'isCustom' => false
        ]);


   
    }elseif($this->activeTab =='DriverEmergency') {

    $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
    $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
    
    if($this->selectedDate == 'custom'){
        $this->selectedFromDate;
        $this->selectedToDate;
    }else{
        $this->selectedFromDate ='';
        $this->selectedToDate =''; 
    }
 
    switch ($this->selectedDate) {
        case 'all':
            $fromDate = null;
            $toDate = null;
            break;
        case 'today':
            $fromDate = Carbon::today();
            $toDate = Carbon::today()->endOfDay();
            break;
        case 'yesterday':
            $fromDate = Carbon::yesterday();
            $toDate = Carbon::yesterday()->endOfDay();
            break;
        case 'thisWeek':
            $fromDate = Carbon::now()->subDays(7)->startOfDay();
            $toDate = Carbon::now();
            break;
        case 'thisMonth':
            $fromDate = Carbon::now()->startOfMonth();
            $toDate = Carbon::now()->endOfMonth();
            break;
        default:
            $fromDate = $fromDate;
            $toDate = $toDate;
            break;
    }

    $driver_list = DB::table('driver_emergency')
    ->leftjoin('driver', 'driver_emergency.driver_emergency_driver_id', '=', 'driver.driver_id')
    ->leftJoin('remark_data', 'remark_data.remark_driver_emeregncy_id', '=', 'driver_emergency.driver_emergency_driver_id')
    ->where(function ($query) {
        $query->where('driver.driver_name', 'like', '%' . $this->search . '%')
            ->orWhere('driver.driver_mobile', 'like', '%' . $this->search . '%');
    })
    ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
        return $query->whereBetween('driver_emergency.created_at', [$fromDate, $toDate]);
    }) 
    ->orderByDesc('driver_emergency.driver_emergency_id')
    ->paginate(10);

    // dd($driver_list);
    $buket_map_data = [];

    foreach($driver_list as $location_data){
        $add_data['driver_emergency_driver_lat'] = $location_data->driver_emergency_driver_lat;
        $add_data['driver_emergency_driver_long'] = $location_data->driver_emergency_driver_long;
        $add_data['driver_name'] = $location_data->driver_name;
        $add_data['driver_last_name'] = $location_data->driver_last_name;
        $add_data['driver_mobile'] = $location_data->driver_mobile;
        $unix_time = $location_data->driver_emergency_request_timing; 

        $carbonDateTime = Carbon::createFromTimestamp($unix_time);
        $normalDateTime = $carbonDateTime->toDateTimeString();
        // $data = $convertedDates;
        $currentDateTime = Carbon::now();  
        $carbonDate = Carbon::parse($normalDateTime);
        $hoursDifference = $carbonDate->diffInHours($currentDateTime);
        $daysDifference = $carbonDate->diffInDays($currentDateTime);
        // Format the date difference as a human-readable message
        $add_data['time_diffrence'] =  $carbonDate->diffForHumans();

        array_push($buket_map_data, $add_data);
    }       

    if($this->check_for == 'custom'){
        return view('livewire.admin.ambulance.booking-emergency-component',[
            'isCustom' => true
        ],compact('buket_map_data', 'driver_list'));
    }
    return view('livewire.admin.ambulance.booking-emergency-component',[
        'isCustom' => false
    ],compact('buket_map_data', 'driver_list'));

}

        return view('livewire.admin.ambulance.driver-auto-search-component');
    }
}