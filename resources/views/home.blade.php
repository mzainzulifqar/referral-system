@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Users referred by you</h2></div>
                <div class="card-body">
                   @if(isset(Auth::user()->referrals))
               <table class="table table-striped ">
                   <thead>
                       <tr>
                           <th>Name</th>
                           <th>Email</th>
                       </tr>
                   </thead>
                   <tbody>
                    @foreach (Auth::user()->referrals as $rf)
                       <tr>
                           <td>{{$rf->name}}</td>
                           <td>{{$rf->email}}</td>
                       </tr>
                       @endforeach
                   </tbody>
               </table>
               @else
               <h2 class="text-center">No referred User yet</h2>
               @endif

                   </div>
                </div>
                </div>
                <div class="col-md-4">
                    
                
            <div class="card">
                <div class="card-header"> <h3>Your Referral Address is:</h3></div>

                <div class="card-body">

                   
                    <span>{{route('register',['referral_id' => Auth::user()->referral_id])}}</span>
                </div>
            </div>
            <div class="card" style="margin-top: 10px;">
                <div class="card-header"> <h3>Your Referral Balance is:</h3></div>

                <div class="card-body">

                   
                    <h2 class="text-center"><span class="text-center">{{Auth::user()->balance}} Rs</span></h2>
                </div>
            </div>
        

           </div>
        </div>
        </div>
    </div>
</div>
@endsection
