var app = angular.module("app", []);
app.controller("ListController", ['$scope', '$window', function ($scope, $window) {

        var answers = angular.fromJson($window.answers);
        if (answers != '') {
            $scope.items = answers;
        } else {
            $scope.items = [
                {
                    'key': 0,
                    'title': '',
                    'image': '/uploads/film.jpg',
                    'description': '',
                    'filename' : ''
                },
            ];
        }
        $scope.addNew = function (item) {
            $scope.items.push({
                'key': $scope.items.length,
                'title': '',
                'image': '/uploads/film.jpg',
                'description': '',
                'filename':''
            });
        };

        $scope.remove = function () {
            var newDataList = [];
            $scope.selectedAll = false;
            angular.forEach($scope.items, function (selected) {
                if (!selected.selected) {
                    newDataList.push(selected);
                }
            });
            $scope.items = newDataList;
        };

        $scope.checkAll = function () {
            if (!$scope.selectedAll) {
                $scope.selectedAll = true;
            } else {
                $scope.selectedAll = false;
            }
            angular.forEach($scope.items, function (item) {
                item.selected = $scope.selectedAll;
            });
        };


    }]);