@extends('layouts.app')

@section('content')


                    
<section class="clear table-section1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">        
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Property Listings</span>
        </div>
        <div class="relative d-flex align-items-center justify-content-between">
          <h6 class="h6 fontweight-700">Property Listings <img src="images/Arrow-down.svg" class="arrow-down" alt=""></h6>
          <div class="d-flex">
            <div class="form-group mr-3">
              <input type="search" class="form-control search-input">
              <img src="images/search-icon.svg" class="search-icon" alt=""> 
              <i class="fas fa-times-circle crose-icon"></i>
            </div>
            <button type="button" class="btn btn-black">Search</button>
          </div>
        </div>
        <div class="my-table">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Listing</th>
                <th>Property</th>
                <th>Suburb</th>
                <th>Type</th>
                <th>Price</th>
                <th>Assigned To <span class="display-ib"><!--<i class="fas fa-arrow-down"></i>--> <i class="fas fa-arrow-up"></i></span></th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="property-listing-detail.html">40408820</a></td>
                <td>ResLease</td>
                <td><span class="overflow_elips width260">Goes here on a single line to text..</span></td>
                <td>Paga Hill</td>
                <td>Apartment</td>
                <td>K 5,800</td>
                <td>Chikelu Obasea</td>
                <td><span class="chips chips-blue">Leased</span></td>
                <td>
                  <div class="dropdown dropleft">
                    <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td><a href="property-listing-detail.html">40408820</a></td>
                <td>ResLease</td>
                <td><span class="overflow_elips width260">Goes here on a single line to text..</span></td>
                <td>Ela Beach</td>
                <td>Townhouse</td>
                <td>K 5,800</td>
                <td>Dushane Daniel</td>
                <td><span class="chips chips-green">Available</span></td>
                <td>
                  <div class="dropdown dropleft">
                    <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td><a href="property-listing-detail.html">40408820</a></td>
                <td>Commericial</td>
                <td><span class="overflow_elips width260">Goes here on a single line to text..</span></td>
                <td>Town                </td>
                <td>Retail</td>
                <td>K 5,800</td>
                <td>Jennifer Reid                </td>
                <td><span class="chips chips-gray">Draft</span></td>
                <td>
                  <div class="dropdown dropleft">
                    <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td><a href="property-listing-detail.html">40408820</a></td>
                <td>ResLease</td>
                <td><span class="overflow_elips width260">Goes here on a single line to text..</span></td>
                <td>Ela Beach</td>
                <td>Townhouse</td>
                <td>K 5,800</td>
                <td>Dushane Daniel</td>
                <td><span class="chips chips-green">Available</span></td>
                <td>
                  <div class="dropdown dropleft">
                    <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                  <td><a href="property-listing-detail.html">40408820</a></td>
                  <td>ResLease</td>
                  <td><span class="overflow_elips width260">Goes here on a single line to text..</span></td>
                  <td>Ela Beach</td>
                  <td>Townhouse</td>
                  <td>K 5,800</td>
                  <td>Dushane Daniel</td>
                  <td><span class="chips chips-green">Available</span></td>
                  <td>
                    <div class="dropdown dropleft">
                      <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                        <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                        <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                      </div>
                    </div>
                  </td>
              </tr>
              <tr>
                    <td><a href="property-listing-detail.html">40408820</a></td>
                    <td>ResLease</td>
                    <td><span class="overflow_elips width260">Goes here on a single line to text..</span></td>
                    <td>Ela Beach</td>
                    <td>Townhouse</td>
                    <td>K 5,800</td>
                    <td>Dushane Daniel</td>
                    <td><span class="chips chips-green">Available</span></td>
                    <td>
                      <div class="dropdown dropleft">
                        <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                          <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                          <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                        </div>
                      </div>
                    </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection
