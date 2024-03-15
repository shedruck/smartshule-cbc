/*
 * ngscJS
 *  @author Ben
 */
var calc = angular.module('Calc', []);
calc.controller('calcctr', ['$scope', '$http', '$timeout', '$window', function ($scope, $http, $timeout, $window)
    {
        $scope.rq = {supplier: '', items: [], date: '', total: 0};
        $scope.rst = {pending: [], approved: [], rejected: []};
        $scope.status = [{id: 1, name: 'OK'}, {id: 0, name: 'Reject'}];
        $scope.success = 0;
        $scope.comm = '';
        $scope.error = 0;

        $scope.addItem = function ()
        {
            $scope.rq.items.push({qty: 0, cost: 0, description: ""});
        };
        $scope.removeItem = function (item)
        {
            $scope.rq.items.splice($scope.rq.items.indexOf(item), 1);
        };
        $scope.calc_sub_total = function ()
        {
            var total = 0.00;
            angular.forEach($scope.quote.items, function (item, key)
            {
                total += (item.qty * item.cost);
            });
            $scope.rq.sub_total = total;
            return total;
        };
        $scope.calc_total = function ()
        {
            var total = 0.00;
            angular.forEach($scope.rq.items, function (item, key)
            {
                total += (item.qty * item.cost);
            });
            $scope.rq.total = total;
            return total;
        };
        $scope.getActions = function ()
        {
            $scope.add = 0;
            $scope.error = 0;
            $scope.errors = "";
            $http.get(BASE_URL + "admin/calc/lists").success(function (data)
            {
                $scope.clients = data.clients;
                $scope.rq.next = data.next;
                $scope.products = data.products;
                $scope.settings = data.settings;
            });
        };
        $scope.sel_item = function (item)
        {
            item.qty = '';
            $scope.calc_sub_total();
        };
        $scope.addItem();

        $scope.pox = function ()
        {
            if (typeof rl !== 'undefined')
            {
                $scope.rq = rl;
            }
            if (typeof rx !== 'undefined')
            {
                $scope.chat = rx;
            }
            if (typeof pdx !== 'undefined')
            {
                $scope.rst.pending = pdx;
            }
            if (typeof apx !== 'undefined')
            {
                $scope.rst.approved = apx;
            }
            if (typeof rjx !== 'undefined')
            {
                $scope.rst.rejected = rjx;
            }
        };
        $scope.pox();
        $scope.post = function (id)
        {
            $http.post(BASE_URL + 'admin/expenses/post_comment', {req: id, msg: $scope.comm})
                    .success(function (data)
                    {
                        if (data.code === 400)
                        {
                            $scope.error = 1;
                            $scope.errors = data.errors;
                        }
                        else
                        {
                            $scope.errors = [];
                            $scope.success = 1;
                            $timeout(function ()
                            {
                                $scope.comm = '';
                                $scope.messg = "Message Posted";
                                window.location.reload()
                            }, 200);
                        }
                    });
        };
        $scope.sett = function (id, status, req)
        {
            $http.post(BASE_URL + 'admin/expenses/post_status', {id: id, status: status})
                    .success(function (data)
                    {
                        if (data.code === 400)
                        {
                            $scope.error = 1;
                            $scope.errors = data.errors;
                        }
                        else
                        {
                            $scope.errors = [];
                            $scope.success = 1;

                            $timeout(function ()
                            {
                                $scope.messg = "Item Updated";
                                window.location.href = BASE_URL + 'admin/expenses/view_req' + '/' + req;
                            }, 1000);
                        }
                    });
        };

        $scope.putReq = function ()
        {
            $http.post(BASE_URL + 'admin/expenses/create_req', $scope.rq)
                    .success(function (data)
                    {
                        if (data.code === 400)
                        {
                            $scope.error = 1;
                            $scope.errors = data.errors;
                            angular.forEach(data.errors, function (value, key)
                            {
                                //toaster.pop('error', "Error ", value);
                            });
                        }
                        else
                        {
                            $scope.errors = [];
                            $scope.success = 1;
                            $timeout(function ()
                            {
                                $scope.rq = {supplier: '', items: [], date: '', total: 0};
                                $scope.addItem();
                                $scope.messg = "Requisition Successfully Added. Awaiting Approval";
                            });
                        }
                    });
        };
        $scope.saveReq = function (id)
        {
            $http.post(BASE_URL + 'admin/expenses/update_req' + '/' + id, $scope.rq)
                    .success(function (data)
                    {
                        if (data.code === 400)
                        {
                            $scope.error = 1;
                            $scope.errors = data.errors;
                            angular.forEach(data.errors, function (value, key)
                            {
                                //toaster.pop('error', "Error ", value);
                            });
                        }
                        else
                        {
                            $scope.errors = [];
                            $scope.success = 1;
                            $scope.messg = "Requisition Successfully updated";

                            $timeout(function ()
                            {
                                $scope.rq = {supplier: '', items: [], date: '', total: 0};
                            }, 3000);
                            $timeout(function ()
                            {
                                window.location.href = BASE_URL + 'admin/expenses/requisitions';
                            }, 1000);
                        }
                    });
        };
    }])
        .controller('Qctrl', function ($scope, $http, $timeout)
        {
            console.log('polling in pohgress', Q);
            var interval = 10000, //10 second
                    err = 0,
                    xpromise; //pointer to the promise from $timeout service

            var get_data = function ()
            {
                $http.get(BASE_URL + 'api/poll')
                        .then(function (res)
                        {
                            $scope.data = res.data.args;
                            err = 0;
                            nextRun();
                        })
                        .catch(function (res)
                        {
                            $scope.data = 'An error occurred';
                            nextRun(++err * 2 * interval);
                        });
            };

            var cancelNextRun = function ()
            {
                $timeout.cancel(xpromise);
            };

            var nextRun = function (mill)
            {
                mill = mill || interval;
                //clear last timeout before starting a new one
                cancelNextRun();
                xpromise = $timeout(get_data, mill);
            };
            //Start polling
            get_data();

            // clear timeout when view is destroyed
            $scope.$on('$destroy', function () {
                cancelNextRun();
            });

            $scope.data = 'Loading...';
        })
        .controller('messctr', ['$scope', '$http', '$timeout', '$window', function ($scope, $http, $timeout, $window)
            {
                $scope.convo = {title: '', messages: []};
                $scope.getConversation = function (id)
                {
                    if (id == 234) {
                        $scope.convo = {
                            title: 'My Fee Balance is Incorrect',
                            messages: [
                                {
                                    "from": "Frank Cheserem",
                                    "to": "Prairie School",
                                    "class": "sent",
                                    "timestamp": "March 6, 2014, 20:08 pm",
                                    "content": "Please check my balance is Wrong. Can you send me statement"
                                }]
                        };
                    }
                    else {
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
            }])
        .filter('ceil', function ()
        {
            return function (value)
            {
                return Math.ceil(value);
            };
        })
        .filter('propsFilter', function ()
        {
            return function (items, props)
            {
                var out = [];
                if (angular.isArray(items))
                {
                    var keys = Object.keys(props);
                    items.forEach(function (item)
                    {
                        var itemMatches = false;
                        for (var i = 0; i < keys.length; i++)
                        {
                            var prop = keys[i];
                            var text = props[prop].toLowerCase();
                            if (item[prop].toString().toLowerCase().indexOf(text) !== -1)
                            {
                                itemMatches = true;
                                break;
                            }
                        }

                        if (itemMatches)
                        {
                            out.push(item);
                        }
                    });
                }
                else
                {
                    // Let the output be the input untouched
                    out = items;
                }

                return out;
            };
        })
        .filter('currentdate', ['$filter', function ($filter)
            {
                return function ()
                {
                    return $filter('date')(new Date(), 'dd MMMM yyyy');
                };
            }])
        .filter('nl2br', function ($sce)
        {
            return function (msg, is_xhtml)
            {
                var is_xhtml = is_xhtml || true;
                var breakTag = (is_xhtml) ? '<br />' : '<br>';
                var msg = (msg + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
                return (msg === 'undefined' || msg === 'null') ? '' : $sce.trustAsHtml(msg);
            };
        });