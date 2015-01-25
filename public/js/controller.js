angular.module('todoApp', ['todoApp.service'])
  .controller('TodoController',['$scope','Member', function($scope,Member){

    Member.getData(function(data){
      $scope.datas=data;
    });

    $scope.add = function(name,phone)
    {
      console.log($scope.member);
      if ($scope.member.id < 0 || $scope.member.id == undefined)
       {
         Member.addData(name,phone,function(){
            Member.getData(function(data){
               $scope.datas=data;
              });        
          });
       }
       else if($scope.member.id != undefined )
       {
         Member.editData($scope.member,function(){
            Member.getData(function(data){
               $scope.datas=data;
              });        
          });
       }
      
       $scope.member="";
    }

    $scope.del = function(id)
    {
      Member.delData(id,function(data){
        Member.getData(function(data){
            $scope.datas=data;
          });
      });
    }

    $scope.edit = function(data)
    {
      
      var member = {

          id    : data._id.$id,
          name  : data.Name,
          phone : data.Phone

      };

      $scope.member=member;
      
    }

  }]);