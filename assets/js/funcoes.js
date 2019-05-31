
    var campos_max =  15;   //max de 5 campos
    var x = 1;
    $('#novo_fator').click (function(e) {
                e.preventDefault();     //prevenir novos clicks
               // if (x < campos_max) {
                $('#fatores').append('<div class="form-row col-4" style="margin-bottom: 10px">\
                  <div class="col">\
                  <input type="text" class="form-control" id="val" name="val[]" placeholder="Digite o valor ' + (x+1) + '" required>\
                  </div>\
                  <a href="#" class="remover_campo btn btn-danger"margin-top: 15px"><i class="fas fa-times"></i></a>\
                  </div>');
                x++;
               // }
               $('#n_label').text(x);
               $('#n').val(x);
             });

    $('#fatores').on("click",".remover_campo",function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
      $('#n_label').text(x);
      $('#n').val(x);
    });