app.controller('ArticleIndex', ['$scope', 'rest', 'toaster', '$filter', function ($scope, rest, toaster, $filter) {

        var errorCallback = function (data) {
            toaster.clear();
            toaster.pop('error', "status: " + data.status + " " + data.name, data.message);
        }

        rest.path = 'v1/article';
        rest.all().success(function (data) {
            $scope.posts = $filter('filter')(data);
        }).error(errorCallback);

}])

app.controller('ArticleView', ['$scope', 'rest', 'toaster', function ($scope, rest, toaster) {

        rest.path = 'v1/article';

        var errorCallback = function (data) {
            toaster.clear();
            if (data.status == undefined) {
                angular.forEach(data, function (error) {
                    toaster.pop('error', "Field: " + error.field, error.message);
                });
            } else {
                toaster.pop('error', "code: " + data.code + " " + data.name, data.message);
            }
        };

        $scope.post = {};

       
        rest.one().success(function (data) {
            $scope.post = data;
        }).error(errorCallback);

}])