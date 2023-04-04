<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bill book Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Bill Book</h2>
    <form action="#">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
        </div>
        <div class="form-group">
            <label>Phone:</label>
            <input type="number" class="form-control" id="phone" placeholder="Enter phone" name="phone">
        </div>

        <div class="container">
            <h2>Items : </h2>

            <table class="table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr class="trhead" data-id="0">
                    <td><input type="text" class="form-control" name="product[]" data-id="0"></td>
                    <td><input type="number" class="form-control quantity " id="qty0" name="quantity[]" min="0" data-id="0" oninput="this.value =
                    !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"></td>
                    <td><input type="number" class="form-control price " id="price0" name="price[]" data-id="0" onkeyup="if(this.value<0){this.value= this.value * -1}"></td>
                    <td><input type="number" class="form-control total" id="total0" name="total[]" data-id="0" disabled></td>
                    <td>
                        <button type="button" class="btn btn-primary addclone" data-id="0">+</button>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td><label >Total Amount:</label></td>
                    <td  colspan="2" >
                        <div>
                        <input type="number" class="form-control float-end totalAmount" id="totalAmount" disabled>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><label >Discount:</label></td>
                    <td  colspan="2" >
                        <div>
                            <input type="number" id="discount_id" class="form-control float-end discount"  onkeyup="if(this.value<0){this.value= this.value * -1}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><label >Bill Amount:</label></td>
                    <td  colspan="2" >
                        <div>
                            <input type="number"  id="bill_amount" class="form-control float-end" disabled>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
            <button type="submit" class="btn btn-primary save">Save</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            let i=0;
            $(".addclone").click(function(){
                i++;

                $(".trhead").clone().appendTo("tbody").removeClass("trhead").addClass("trhead"+i).attr('data-id',i);
                $(".trhead"+i+" .quantity").attr('id',"qty"+i).attr('data-id',i).val("")
                $(".trhead"+i+" .price").attr('id',"price"+i).attr('data-id',i).val("")
                $(".trhead"+i+" .total").attr('id',"total"+i).attr('data-id',i).val("")
                $(".trhead"+i+" .addclone").html('-').removeClass("addclone").removeClass("btn-primary").addClass('btn-danger').addClass("removeClone").attr('data-id',i);
            });
            $(document).on('click',".removeClone",function(e){
                e.preventDefault()
                $('.trhead'+$(this).data('id')).remove()
                let fTotal = 0;

                for(let j=0; j<=i;j++){
                    console.log('test', $("#total"+j).val())
                    fTotal += $("#total"+j).val() != "" && $("#total"+j).val() != undefined ? parseInt($("#total"+j).val()) : 0
                }
                $('.totalAmount').val(fTotal)
                var disc = $('#discount_id').val() !=  "" ?parseInt($('#discount_id').val()): 0;
                var discount = fTotal - (fTotal * disc / 100).toFixed(2);
                $('#bill_amount').val(discount)
            });

            $(document).on('keyup','.quantity',function(e){
                var price = $("#price"+$(this).data('id')).val() != "" ? parseInt($("#price"+$(this).data('id')).val()) : 0;
                var qty =$(this).val() !=  "" ? parseInt($(this).val()) : 0;
                var total =  price * qty  ;
                total = total != null ? total : 0
                let fTotal = 0;
                $("#total"+$(this).data('id')).val(total)
                for(let j=0; j<=i;j++){
                    fTotal += $("#total"+j).val() != "" && $("#total"+j).val() != undefined ? parseInt($("#total"+j).val()) : 0
                }
                $('.totalAmount').val(fTotal)
                var disc = $('#discount_id').val() !=  "" ?parseInt($('#discount_id').val()): 0;
                var discount = fTotal - (fTotal * disc / 100).toFixed(2);
                $('#bill_amount').val(discount)
            })

            $(document).on('keyup','.price',function (p){
                var qty= $("#qty"+$(this).data('id')).val() != "" ? parseInt($("#qty"+$(this).data('id')).val()) : 0;
                var price =$(this).val() !=  "" ?parseInt ($(this).val()) : 0;
                var total =  price * qty  ;
                total = total != null ? total : 0
                $("#total"+$(this).data('id')).val(total)
                let fTotal = 0;
                $("#total"+$(this).data('id')).val(total)
                for(let j=0; j<=i;j++){
                    fTotal += $("#total"+j).val() != "" && $("#total"+j).val() != undefined ? parseInt($("#total"+j).val()) : 0
                }
                $('.totalAmount').val(fTotal)
                var disc = $('#discount_id').val() !=  "" ?parseInt($('#discount_id').val()): 0;
                var discount = fTotal - (fTotal * disc / 100).toFixed(2);
                $('#bill_amount').val(discount)
            })
            $(document).on("keyup","#discount_id",function (){
                var disc = $('#discount_id').val() !=  "" ? parseInt($('#discount_id').val()): 0;

                if(disc < 0 || disc > 100){
                    $('#discount_id').val(0)
                }else{
                    var main = $('#totalAmount').val() !=  "" ?parseInt($('#totalAmount').val()) : 0;

                    var discount = main - (main * disc / 100).toFixed(2);
                    $('#bill_amount').val(discount)
                    console.log("success",discount)
                }
            })
        });
    </script>
</body>
</html>
