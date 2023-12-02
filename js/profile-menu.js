$(document).ready(function () {
    $(".twoContent").hide();
    $(".btnOne").addClass('activeProfile');
         
    $(".btnTwo").click(function () {
        $(".oneContent").hide();
        $(".twoContent").show();

        $('.btnOne').removeClass('activeProfile');
        $(this).addClass('activeProfile');

    });
    
    $(".btnOne").click(function () {
        $(".twoContent").hide();
        $(".oneContent").show()

        $('.btnTwo').removeClass('activeProfile');
        $(this).addClass('activeProfile');
     });
  });