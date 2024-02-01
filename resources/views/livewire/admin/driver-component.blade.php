<div class="content">
  <style>
    .loader{
    width: 150px;
    height: 150px;
    margin: 40px auto;
    transform: rotate(-45deg);
    font-size: 0;
    line-height: 0;
    animation: rotate-loader 5s infinite;
    padding: 25px;
    border: 1px solid #8a474d1f;
}
.loader .loader-inner{
    position: relative;
    display: inline-block;
    width: 50%;
    height: 50%;
}
.loader .loading{
    position: absolute;
    background: #dcdee5;
}
.loader .one{
    width: 100%;
    bottom: 0;
    height: 0;
    animation: loading-one 1s infinite;
}
.loader .two{
    width: 0;
    height: 100%;
    left: 0;
    animation: loading-two 1s infinite;
    animation-delay: 0.25s;
}
.loader .three{
    width: 0;
    height: 100%;
    right: 0;
    animation: loading-two 1s infinite;
    animation-delay: 0.75s;
}
.loader .four{
    width: 100%;
    top: 0;
    height: 0;
    animation: loading-one 1s infinite;
    animation-delay: 0.5s;
}
@keyframes loading-one {
    0% {
        height: 0;
        opacity: 1;
    }
    12.5% {
        height: 100%;
        opacity: 1;
    }
    50% {
        opacity: 1;
    }
    100% {
        height: 100%;
        opacity: 0;
    }
}
@keyframes loading-two {
    0% {
        width: 0;
        opacity: 1;
    }
    12.5% {
        width: 100%;
        opacity: 1;
    }
    50% {
        opacity: 1;
    }
    100% {
        width: 100%;
        opacity: 0;
    }
}
@keyframes rotate-loader {
    0% {
        transform: rotate(-45deg);
    }
    20% {
        transform: rotate(-45deg);
    }
    25% {
        transform: rotate(-135deg);
    }
    45% {
        transform: rotate(-135deg);
    }
    50% {
        transform: rotate(-225deg);
    }
    70% {
        transform: rotate(-225deg);
    }
    75% {
        transform: rotate(-315deg);
    }
    95% {
        transform: rotate(-315deg);
    }
    100% {
        transform: rotate(-405deg);
    }
}
  </style>
    <div class="container-fluid">
        @if ($isOpen)
            @include('livewire.employee-form')
        @endif
        @if (session()->has('message') && session()->has('type') == 'delete')
            <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
         @include('livewire.admin.driver-nav-component')
            
            <div class="card">
              <div class="card-header">
               
                <div class="row">
                    
                    <div class="col __col-{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
                      <div class="form-group">
                          <label class="custom__label" for="fromDate">From </label>
                          <input wire:model.live="selectedFromDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                      </div>
                    </div>
                    <div class="col __col-{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
                      <div class="form-group">
                        <label class="custom__label" for="toDate">To</label>
                        <input wire:model.live="selectedToDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                      </div>
                    </div>

                    <div class="col -{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
                        <div class="form-group">
                          <label class="custom__label">Select</label>
                          <select wire:model.live.debounce.150ms="selectedDate" wire:mode.live="selectedDate" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                          <option selected value="all">All</option>
                          <option value="today">Today</option>
                          <option value="yesterday">Yesterday</option>
                          <option value="thisWeek">This Week</option>
                          <option value="thisMonth">This Month</option>
                        </select>
                        </div>
                    </div>
                    @if($this->activeTab == 'UnderVerificationBySelf')
                    <div class="col __col-3">
                        <div class="form-group">
                          <label class="custom__label">Driver By Status</label>
                          <select wire:model.live.debounce.150ms="driverVerificationStatus" wire:mode.live="driverVerificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                          <option selected value="UnderVerification">Under Verification(All)</option>
                          <option  value="UnderVerificationBySelf">Under Verification(By Self)</option>
                          <option  value="UnderVerificationByPartner">Under Verification(By Partner)</option>
                         
                        </select>
                        </div>
                    </div>
                    @endif

                    @if($this->activeTab == 'walletBalance')
                    <div class="col __col-3">
                        <div class="form-group">
                          <label class="custom__label">Wallet Balance</label>
                          <select wire:model.live.debounce.150ms="walletBalanceFilter" wire:mode.live="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                          <option  value="positiveBalance">Positive Balance</option>
                          <option  value="zeroBalance">Zero Balance</option>
                          <option  value="negativeBalance">Negative Balance</option>
                        </select>
                        </div>
                    </div>
                    @endif

                    <div class="col __col-3">
                      <div class="form-group">
                          <label class="custom__label" for="toDate">Search</label>
                          <input type="search" wire:model.live.debounce.50ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                      </div>
                    </div>
                </div>
                
              </div>
              <div class="row d-none card-header">
                <div class="col-3">
                          <div class="form-group">
                            <label class="custom__label">Wallet Balance</label>
                            <select wire:model.live.debounce.150ms="walletBalanceFilter" wire:mode.live="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option  value="positiveBalance">Positive Balance</option>
                            <option  value="zeroBalance">Zero Balance</option>
                            <option  value="negativeBalance">Negative Balance</option>
                          </select>
                          </div>
                      </div>
                      <div class="col-3">
                          <div class="form-group">
                            <label class="custom__label">Wallet Balance</label>
                            <select wire:model.live.debounce.150ms="walletBalanceFilter" wire:mode.live="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option  value="positiveBalance">Positive Balance</option>
                            <option  value="zeroBalance">Zero Balance</option>
                            <option  value="negativeBalance">Negative Balance</option>
                          </select>
                          </div>
                      </div>
                      <div class="col-3">
                          <div class="form-group">
                            <label class="custom__label">Wallet Balance</label>
                            <select wire:model.live.debounce.150ms="walletBalanceFilter" wire:mode.live="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option  value="positiveBalance">Positive Balance</option>
                            <option  value="zeroBalance">Zero Balance</option>
                            <option  value="negativeBalance">Negative Balance</option>
                          </select>
                          </div>
                      </div>
                      <div class="col-3">
                          <div class="form-group">
                            <label class="custom__label">Wallet Balance</label>
                            <select  class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option  value="positiveBalance">Positive Balance</option>
                            <option  value="zeroBalance">Zero Balance</option>
                            <option  value="negativeBalance">Negative Balance</option>
                          </select>
                          </div>
                      </div>
              </div>

            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
                <div  wire:loading.remove wire:target="filterCondition" class="card-body p-2">
                <table class="table custom__table table-bordered table-sm">
                <tr>
                    <th>Sr.</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Wallet</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Bonus</th>
                    <th>Duty</th>
                    <th>Booking</th>
                    <!-- <th>Remark Details</th> -->
                    <th>City</th>
                    <th> State</th>
                    <th>RC No.</th>
                    <!-- <th>DL No.</th> -->
                    <th>Action</th>
                </tr>
@php
$srno = 1
@endphp
                @foreach ($drivers as $driver)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $driver->driver_id }}</td>
                        <td>{{ $driver->driver_name.' '.$driver->driver_last_name }}</td>
                        <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_wallet_amount }}</td>
                        <td>{{ $driver->created_at }}</td>
                        <td>
                        @if($driver->driver_created_by=='0')
												 Self
												 @else
												 Partner
                        @endif
                        </td>
                        <td>
                        {{ $driver->join_bonus_status ==1 ? 'Yes' : 'No' }}

                        </td>
                        <td>
                          {{ $driver->driver_duty_status }}
                          <!-- Booking Status: {{ $driver->driver_on_booking_status == 0 ? 'Free' : 'In Booking' }} -->
                        </td>
                        
                        <td>{{ $driver->driver_on_booking_status == 0 ? 'Free' : 'Ongoing' }}</td>
                        <td>{{ $driver->city_name }}</td>
                        <td>{{ $driver->state_name }}</td>
                        <td>{{ $driver->vehicle_rc_number }}</td>
                        <td class="action__btn lbtn-group">
                            <button wire:click="edit({{ $driver->driver_id }})" class="pt-0 pl-2 pr-2 pb-1 btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
                            <button wire:confirm="Are you sure you want to delete this post?"
                                wire:click="delete({{ $driver->driver_id }})" class="pt-0 pl-2 pr-2 pb-1 btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                @endforeach

            </table>
            <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
            <div class="custom__pagination pt-1 card-footer__ clearfix">
                        {!! $drivers->links() !!}
            </div>
            </div>
            </div>
          
            <div class="container">
    <div class="row" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty">
        <div class="col">
            <div class="loader">
                <div class="loader-inner">
                    <div class="loading one"></div>
                </div>
                <div class="loader-inner">
                    <div class="loading two"></div>
                </div>
                <div class="loader-inner">
                    <div class="loading three"></div>
                </div>
                <div class="loader-inner">
                    <div class="loading four"></div>
                </div>
            </div>
        </div>
    </div>
</div>
             <!-- <div style="text-align:center !important; display:block !important" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>Processing..</div> -->

    </div>
    </div>
</div>



