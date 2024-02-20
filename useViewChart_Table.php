<!-- VIEW RESIDENT CHART AND TABLE -->
<div class="modal fade" id="viewResidentChart_Table" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg"> <!-- Use modal-lg class for large size -->
   <div class="modal-content">
     
               <!-- Modal Header -->
               <div class="modal-header">
                   <h4 class="modal-title">RESIDENTS CHART AND TABLE</h4>
                 </div>

                 <div class="card" style="width: 90%; margin: 0 auto; overflow-x: auto;">
             <div class="card-body">
                 <div id="population_data"></div>
             </div>
           </div>
             
             <div class="container">
             <div class="row justify-content-center">
               <div class="card" style="width: 25rem;">
                 <div class="card-body">
                   <h5 class="card-title">Population by Gender</h5>
                   <hr>
                   <canvas id="myChart" width="500" height="400"></canvas>
                 </div>
               </div>

               <div class="card" style="width: 25rem;">
                 <div class="card-body">
                   <h5 class="card-title">B.M.I Age 20 above</h5>
                   <hr>
                   <canvas id="myChart2" width="500" height="400"></canvas>
                 </div>
               </div>
             </div>
           </div>

                 <!-- Modal Footer -->
                 <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel" onclick="clearChart_table()">Back</button>
                 </div>

        </div>
     </div>
  </div>