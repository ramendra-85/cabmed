<?php

namespace App\Livewire\Admin\Ambulance;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;

class BookingEmergencyComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$selectedBookingType,$check_for,$selectedbookingStatus,$checkEmergencyStatus,$checkbookingEmergency,
    $activeTab,$consumerEmergencyId,$consumerEmergency,$events = [];
    
    

    public $isOpen = 0;
    use WithPagination;
    use WithFileUploads;
    use WithoutUrlPagination;


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

        // $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
        // $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
        
        // if($this->selectedDate == 'custom'){
        //     $this->selectedFromDate;
        //     $this->selectedToDate;
        // }else{
        //     $this->selectedFromDate ='';
        //     $this->selectedToDate =''; 
        // }
     
        // switch ($this->selectedDate) {
        //     case 'all':
        //         $fromDate = null;
        //         $toDate = null;
        //         break;
        //     case 'today':
        //         $fromDate = Carbon::today();
        //         $toDate = Carbon::today()->endOfDay();
        //         break;
        //     case 'yesterday':
        //         $fromDate = Carbon::yesterday();
        //         $toDate = Carbon::yesterday()->endOfDay();
        //         break;
        //     case 'thisWeek':
        //         $fromDate = Carbon::now()->subDays(7)->startOfDay();
        //         $toDate = Carbon::now();
        //         break;
        //     case 'thisMonth':
        //         $fromDate = Carbon::now()->startOfMonth();
        //         $toDate = Carbon::now()->endOfMonth();
        //         break;
        //     default:
        //         $fromDate = $fromDate;
        //         $toDate = $toDate;
        //         break;
        // }

        // $consumer_list = DB::table('consumer_emergency')
        // ->leftjoin('consumer', 'consumer_emergency.consumer_emergency_consumer_id', '=','consumer.consumer_id')
        // ->leftjoin('booking_view', 'consumer_emergency.consumer_emergency_booking_id', '=', 'booking_view.booking_id')
        // ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
        //     return $query->whereBetween('consumer_emergency.created_at', [$fromDate, $toDate]);
        // }) 
        // ->where(function ($query) {
        //     $query->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
        //         ->orWhere('consumer.consumer_mobile_no', 'like', '%' . $this->search . '%');
        // })
        // ->orderByDesc('consumer_emergency.consumer_emergency_id')
        // ->paginate(10);

        // $buket_map_data = [];

        // foreach($consumer_list as $location_data){
        //     $add_data['consumer_emergency_consumer_lat'] = $location_data->consumer_emergency_consumer_lat;
        //     $add_data['consumer_emergency_consumer_long'] = $location_data->consumer_emergency_consumer_long;
        //     $add_data['consumer_name'] = $location_data->consumer_name;
        //     $add_data['consumer_mobile_no'] = $location_data->consumer_mobile_no;
        //     $unix_time = $location_data->consumer_emergency_request_timing; 

        //     $carbonDateTime = Carbon::createFromTimestamp($unix_time);
        //     $normalDateTime = $carbonDateTime->toDateTimeString();
        //     // $data = $convertedDates;
        //     $currentDateTime = Carbon::now();  
        //     $carbonDate = Carbon::parse($normalDateTime);
        //     $hoursDifference = $carbonDate->diffInHours($currentDateTime);
        //     $daysDifference = $carbonDate->diffInDays($currentDateTime);
        //     // Format the date difference as a human-readable message
        //     $add_data['time_diffrence'] =  $carbonDate->diffForHumans();

        //     array_push($buket_map_data, $add_data);
        // }

        // if($this->check_for == 'custom'){
        //     return view('livewire.admin.ambulance.booking-emergency-component',[
        //         'isCustom' => true
        //     ],compact('buket_map_data', 'consumer_list'));
        // }

        return view('livewire.admin.ambulance.booking-emergency-component');

}

public function openModal()
{
    $this->isOpen = true;
}

public function closeModal()
{
    $this->isOpen = false;
}

public function showMap($consumerEmergencyId)
{
        $consumerEmergency = DB::table('consumer_emergency')
        ->leftjoin('consumer', 'consumer_emergency.consumer_emergency_consumer_id', '=','consumer.consumer_id')
        ->where('consumer_emergency.consumer_emergency_id','=',$consumerEmergencyId)
        ->orderByDesc('consumer_emergency.consumer_emergency_id')
        ->first();

        $this->consumerEmergency = $consumerEmergency;

    $this->openModal();
}

}
