<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    </head>
    <body>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="generator-tab" data-toggle="tab" href="#generator" role="tab" aria-controls="generator" aria-selected="true">Generator</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="analytics-tab" data-toggle="tab" href="#analytics" role="tab" aria-controls="analytics" aria-selected="false">Analytics</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="generator" role="tabpanel" aria-labelledby="generator-tab">
                <span class="form_output"></span>
                <h1 class="text-center mt-3">Random Score Generator</h1>
                <div class="row mt-5">
                    <div class="col-md-3 offset-md-3">
                        <input type="number" name="scoreMin" id="scoreMin" placeholder="Enter the minimum number" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="scoreMax" id="scoreMax" placeholder="Enter the maximum number" class="form-control" />
                    </div>
                </div>
                <div class="row mt-3">
                    <button class="btn btn-success mx-auto" id="generatorButton">Generate</button>
                </div>
                <h3 class="text-center mt-5">Your Score is:</h3>
                <span id="generatedScore"></span>
            </div>
            <div class="tab-pane fade" id="analytics" role="tabpanel" aria-labelledby="analytics-tab">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="ml-5 mt-3">Scores</h1>
                        <div class="table table-responsive mx-5">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Score</th>
                                        <th>Creation Date</th>
                                        <th>Creation Time</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h1 class="mt-3 text-center">Scores Generated Today</h1>
                        <span id="todayCount"></span>
                    </div> 
                </div>
            </div>
        </div>

        <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
        <script type="text/javascript">
            $(function(){
                $.ajax({
                    url:'/api/scores',
                    method:"get",
                    success:function(data)
                    {
                        console.log(data);
                        var res = data[0];
                        var today = new Date();
                        var todayCount = data[1];

                        if(res != null){
                            res.forEach(function(item,index){
                                $('tbody').append('<tr> <td>'+item['scores']+'</td> <td>'+item['creation_date']+'</td> <td>'+item['creation_time']+'</td> </tr>');
                            })
                        }
                        $("#todayCount").html('<h4 class="text-center count" id="'+todayCount+'">'+todayCount+' Scores</h4>');
                    }
                })
            });

            $('#generatorButton').on('click', function(){
                var scoreMin = parseInt($('#scoreMin').val());
                var scoreMax = parseInt($('#scoreMax').val());

                if(scoreMin < scoreMax){
                    $.ajax({
                        url:'/api/scores/store',
                        method:"POST",
                        data:{
                            scoreMin:scoreMin,
                            scoreMax:scoreMax
                        },
                        dataType:"json",
                        success:function(data)
                        {
                            $('#generatedScore').html('<h4 class="text-center">'+data.score.scores+'</h4>');
                            $('#scoreMin').val('');
                            $('#scoreMax').val('');
                            $('tbody').append('<tr> <td>'+data.score.scores+'</td> <td>'+data.score.creation_date+'</td> <td>'+data.score.creation_time+'</td> </tr>');

                            var oldCount = parseInt($(".count").attr("id"));
                            var newCount = oldCount + 1;

                            $("#todayCount").html('<h4 class="text-center count" id="'+newCount+'">'+newCount+' Scores</h4>');
                             $('.form_output').html('');
                        }
                    })
                }

                else{
                    $('.form_output').html('<div class="alert alert-danger" role="alert"> Maximum Score must be greater than the Minimum Score. </div>');
                }
            });
        </script>
    </body>
</html>
