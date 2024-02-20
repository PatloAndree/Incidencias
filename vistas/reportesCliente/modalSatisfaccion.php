
<form id="frmCalificarSt" method="POST" onsubmit="return agregarSatisfaccion()">
   <div class="modal fade" id="modalSatisfaction" tabindex="-1" role="dialog" aria-labelledby="modalActualizarReporteLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="modalActualizarReporteLabel">Califícame</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">

               <div class="form-group">
                     <input type="text" class="d-none" name="idReporte2" id="idReporte2">

                     <label for="satisfaction">Nivel de Satisfacción:</label>
                     <select class="form-control" id="satisfecho" name="satisfaction">
                           <option value="0">Selecciona una opción</option>
                           <option value="5">Muy Satisfecho</option>
                           <option value="4">Satisfecho</option>
                           <option value="3">Regular</option>
                           <option value="2">Insatisfecho</option>
                           <option value="1">Muy Insatisfecho</option>
                     </select>
                  </div>

                  <button type="submit" class="btn btn-primary">Guardar</button>
               </div>
         </div>
      </div>
   </div>
</form>

