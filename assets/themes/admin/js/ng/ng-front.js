/*
 * ng-front
 *  @author Ben
 */
var front = angular.module('Front', ['angularTrix']);
front.controller('messctr', ['$scope', '$http', '$timeout', '$window', function ($scope, $http, $timeout, $window)
    {
        $scope.convo = {title: '', messages: []};
        $scope.post = {title: '', to: '', message: ''};
        $scope.fresh = false;
        $scope.getConversation = function (id)
        {
            $scope.fresh = false;
            $scope.post = {title: '', to: '', message: ''};
            if (id == 234)
            {
                $scope.convo = {
                    title: 'My Fee Balance is Incorrect',
                    messages: [{
                            "from": "Frank Cheserem",
                            "to": "Prairie School",
                            "class": "sent",
                            "timestamp": "March 6, 2014, 20:08 pm",
                            "content": "Please check my balance is Wrong. Can you send me statement"
                        }]
                };
            }
            else
            {
                $scope.convo = {
                    title: 'Exam Results Missing',
                    messages: [
                        {
                            "from": "Liz Osiani",
                            "to": "Prairie School",
                            "class": "sent",
                            "timestamp": "Dec 21, 2017, 10:28 am",
                            "content": "I cant View exam marks for Brandon. The report Form is empty. Kindly Check or get me the teacher."
                        }]
                };
            }

        };

        $scope.set_new = function ()
        {
            $scope.convo = {title: '', messages: []};
            $scope.fresh = true;
        };
        $scope.send = function ()
        {
            var url = BASE_URL + 'messages/post';

            $http.post(url, $scope.post).success(function (data)
            {
                if (data.code === 400)
                {
                    $scope.error = 1;
                    $scope.errors = data.message;
                }
                else {
                    $scope.success = 1;
                    $scope.post = {title: '', to: '', message: ''};
                    $scope.successMsg = 'Message Success Sent';
                    window.location.reload();
                }
            });
        }

    }])
        .filter('nl2br', ['$sce', function ($sce)
            {
                return function (msg, is_xhtml)
                {
                    var tag1 = '<br />';
                    var tag2 = '<br>';
                    var msg = (msg + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + tag1 + '$2');
                    msg = (msg + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + tag2 + '$2');
                    return (msg === 'undefined' || msg === 'null') ? '' : $sce.trustAsHtml(msg);
                };
            }]);