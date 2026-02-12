$(document).ready(function() 
{

    // Quiz variables

    var mistakes = 0;
    var scrollAmount = 180;
    var current_sub = 0;
    var scrollContainer = $('.qa_subs_scroll_container');
    var content_element = $(".quiz_in");
    var array_all_ques = [];
    var array_ques = [];
    var array_subs = [];
    var array_correct_ans = [];
    var array_wrong_ans = [];
    var array_bins = [];
    var num_of_subs_in_quiz = 0;
    var num_of_ques_in_sub = 0;
    var current_que = 0;
    var current_quiz = 0;
    var current_bin = 0;
    var current_que_in_array = 0;
    var selected_ans;
    var current_prog_bar_val = 0;
    var num_of_bins = 0;
    var run_session_id = 0;
    var lower_bin = false;
    var saved_que_loaded = false;



    // Quiz Functions

    function check_session_avlbl(session_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'check_session_avlbl', 
                    session_id: session_id 
                },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    function get_run_id()
    {
        var session_id = Math.floor(Math.random() * 9999999999999) + 1;
        check_session_avlbl(session_id, (res) => 
        {
            if(res == '0')
            {
                get_run_id();
                return;
            }
            else
            {
                run_session_id = session_id;
            }
        });
    }

    function make_sure_que_loaded()
    {
        var my_interval = setInterval(() => {
            if(current_que == '')
            {
                setTimeout(() => {
                    $(".qa_subs_scroll_container").children().first().click();
                }, 300);
                clearInterval(my_interval);
            }
        }, 1000);
        
    }

    window.get_que_text = function(que_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_que_text', 
                    que_id: que_id 
                },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    window.get_sub_text = function(sub_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_sub_text', 
                    sub_id: sub_id 
                },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    window.get_ans_text = function(ans_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_ans_text', 
                    ans_id: ans_id 
                },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    function load_saved_mistakes(callback)
    {
        $.get("app/actions/quiz-app-action.php?action=load_saved_mistakes&quiz_id="+current_quiz, (res) => 
        {
            if(res != '')
            {
                callback(res);
            }
            else
            {
                // If is'nt saved mistakes data for this quiz_id and user_id
                callback('-1');
            }
        });
    }

    window.load_quiz = async function(quiz_id)
    {
        reset_quiz_data();
        get_run_id();
        current_quiz = quiz_id;
        
        $.get("layout/quiz-app/quiz_in.php", (res) => { content_element.html(res); quiz_loading(true); });
        
        get_num_of_subs_by_quiz_id(quiz_id, function(res)
        {
            num_of_subs_in_quiz = res;
        });

        load_saved_mistakes((res) => 
        {
            if(res != '-1')
            {
                mistakes = res;
                $("#qa_mist_count").html(res);
            }
            else
            {
                mistakes = '0';
                $("#qa_mist_count").html('0');
            }
        });

        get_subs_by_quiz_id(quiz_id, function(res)
        {
            var subs = JSON.parse(res);

            $.each(subs, function (index, value) 
            {
                if(!array_subs.includes(value))
                {
                    array_subs.push(value);
                }
            });

            $(".qa_subs_scroll_container").html("");
            array_subs.sort(function(a, b){ return a - b });
                
            $.each(array_subs, function (index, value)
            { 
                get_sub_text(value, function(res)
                {
                    $(".qa_subs_scroll_container").append(
                        '<div class="qa_subject qa_subject_'
                        + value
                        + '" id="'
                        + value
                        + '">'
                        + res
                        + '</div>');
                });
            });
            
            load_subject(array_subs[0]);
            setTimeout(() => {
                mark_current_sub();
            }, 500);

        });

        load_mistakes();
        load_sub_scroll_fnclty();
        make_sure_que_loaded();
        load_last_que2();

        inisiate_prog_bar(quiz_id, (response) => 
        {
            console.log('response: ', response);
            set_progress_bar(response);
        });
    }

    function inisiate_prog_bar(quiz_id, callback)
    {
        let bin_ansed = 0;
        let bins_total = 0;
    
        // Convert to promise-based logic
        get_subs_list_by_quiz_id(quiz_id, async (subs_list) => {
            const sub_list = JSON.parse(subs_list);
            console.log('sub_list: ', sub_list);
    
            // Use Promise.all to wait for all async operations
            await Promise.all(sub_list.map(async (sub_id) => 
            {
                console.log('sub_id: ', sub_id);
                const nob = await new Promise((resolve) => get_num_of_bins(sub_id, resolve));
                console.log('nob: ', nob);
    
                bins_total += parseInt(nob);
    
                const lrid = await new Promise((resolve) => get_last_run_quiz_id(resolve));
                const last_an_array = await new Promise((resolve) =>
                    get_last_ansed_que_in_sub(lrid, resolve, sub_id)
                );
    
                console.log('last_an_array: ', last_an_array);
    
                if(last_an_array === '') 
                {
                    const mid = await new Promise((resolve) => auto_select_bin(sub_id, resolve));
                    bin_ansed += mid-1;
                    console.log('mid: ', mid);
                } 
                else
                {
                    const last_ansed = JSON.parse(last_an_array);
                    let last_ans_correct = '';
                    let last_ans_que_id = '';

                    for(const [index2, value2] of Object.entries(last_ansed))
                    {
                        if(index2 == 1) 
                        {
                            last_ans_correct = value2;
                        }
                        if(index2 == 0) 
                        {
                            last_ans_que_id = value2;
                        }
                    }

                    console.log('last_ans_que_id: ', last_ans_que_id);
    
                        let my_bin = await new Promise((resolve) =>
                            get_bin_by_que_id(last_ans_que_id, resolve)
                        );
    
                        if(last_ans_correct == 1) 
                        {
                            my_bin++;
                        } 
                        else 
                        {
                            my_bin--;
                        }
    
                        bin_ansed += Math.max(1, Math.min(my_bin, parseInt(nob)));
                        console.log('***MAX***: ', Math.max(1, Math.min(my_bin, parseInt(nob))));
                        console.log('my_bin: ', my_bin);
                }
            }));
    
            console.log('bin_ansed: ', bin_ansed);
            console.log('bins_total: ', bins_total);
    
            // Calculate percentage and invoke callback
            callback((bin_ansed / bins_total) * 100);
        });
    }

    function total_bins_in_quiz(quiz_id, callback) 
    {
        var bins_total = 0;
    
        get_subs_list_by_quiz_id(quiz_id, (subs_list) => {
            subs_list = JSON.parse(subs_list);
            const promises = [];
    
            $.each(subs_list, function(index, sub_id) {
                promises.push(new Promise((resolve, reject) => {
                    get_num_of_bins(sub_id, (nob) => {
                        nob = parseInt(nob);
                        if (nob !== undefined && nob !== null) {
                            bins_total += nob;
                            resolve();
                        } else {
                            reject(`Invalid number of bins for sub_id: ${sub_id}`);
                        }
                    });
                }));
            });
    
            Promise.all(promises)
                .then(() => {
                    callback(bins_total);
                })
                .catch(error => {
                    console.error('Error in total_bins_in_quiz:', error);
                    callback(undefined); // Pass undefined if there’s an error
                });
        });
    }
    

    function get_subs_list_by_quiz_id(quiz_id, callback)
    {
        $.get("app/actions/quiz-app-action.php?action=get_subs_list_by_quiz_id&quiz_id="+quiz_id, (res2) => { callback(res2) });
    }

    function clear_empty_subs()
    {
        $.each(array_subs, function(index, value)
        {
             get_ques_by_sub_id(value, function(res)
             {
                var ques = JSON.parse(res);

                if(ques.length === 0)
                {
                    var ind1 = array_subs.indexOf(value);
                    if(index !== -1)
                    {
                        array_subs.splice(ind1, 1);
                        num_of_subs_in_quiz = array_subs.length;
                    }
                }
             });
        });
    }

    function update_subs_div()
    {
        $(".qa_subs_scroll_container").html("");
        array_subs.sort(function(a, b){ return a - b });

        $.each(array_subs, function (index, value)
        {
            get_sub_text(value, function(res)
            {
                $(".qa_subs_scroll_container").append(
                    '<div class="qa_subject qa_subject_'
                    + value
                    + '" id="'
                    + value
                    + '">'
                    + res
                    + '</div>');
            });
        });

    }

    function reset_quiz_data()
    {
        $(".qa_subs_scroll_container").html("");
        $(".qa_que").html("");
        $(".qa_content_fill").html("");
        $(".qa_ans_fill").html("");
        mistakes = 0;
        load_mistakes();
        array_all_ques = [];
        array_ques = [];
        array_subs = [];
        array_correct_ans = [];
        array_wrong_ans = [];
        num_of_subs_in_quiz = 0;
        selected_ans = 0;
        set_progress_bar(0);
        $('.quiz_in').css('transform', 'rotateY(0deg)');
        current_sub = 0;
        current_que = 0;
        current_prog_bar_val = 0;
        current_que_in_array = 0;
    }

    function reset_subject_data()
    {
        $(".qa_que").html("");
        $(".qa_content_fill").html("");
        $(".qa_ans_fill").html("");
        array_ques = [];
        selected_ans = 0;
        $(".qa_continue").css("background-color", "#222");
        $(".qa_continue").css("border-color", "#222");
        $(".qa_continue").text("");
        update_cleared_subs();
        current_bin = 0;

        // Make sure that the user can scroll in subs
        load_sub_scroll_fnclty();
    }

    function reset_question_data()
    {
        selected_ans = 0;

        // Set the continue button
        $(".qa_continue").css("cursor" ,"default");
        $(".qa_continue").css("background-color" ,"#e5e5e5");
        $(".qa_continue").css("color" ,"#acacac");
        $(".qa_continue").css("border" ,"none");

        $(".qa_continue").hover(
        function()
        {
            $(this).css(
            {
                "background-color": "#e5e5e5", 
                "color": "#acacac" 
            });
        }, 
        function()
        {
            $(this).css(
            {
                "background-color": "#e5e5e5", 
                "color": "#acacac" 
            });
        });

        // Reset the button background
        $(".btm_btn_fill").css("background-color", "transparent");
        $(".qa_btn_text").text("");
    }
    
    function update_cleared_subs()
    {
        clear_empty_subs();

        setTimeout(() => 
        {
            update_subs_div();
        }, 200);

        setTimeout(() => 
        {
            sort_subs_elements();
        }, 200);

        setTimeout(() => 
        {
            $(".qa_subject").off("click");
            $(".qa_subject").click(function()
            {
                var sub_id = $(this).attr("id");
                current_sub = sub_id;
                mark_current_sub();
                load_ques_in_sub();
                auto_select_bin(sub_id, (mid) => 
                {
                    load_que_from_bin(current_sub, mid);
                });
                load_sub_scroll_fnclty();
            });
        }, 600);

    }

    window.load_subject = function(sub_id)
    {
        reset_subject_data();
        current_sub = sub_id;
        
        setTimeout(() => {
            mark_current_sub();
        }, 400);
        
        load_ques_in_sub();

        setTimeout(() => {
            $(".qa_subject").off("click");
            $(".qa_subject").click(function()
            {
                var sub_id = $(this).attr("id");
                current_sub = sub_id;
                mark_current_sub();
                load_ques_in_sub();
                setTimeout(() => {
                    num_of_ques_in_sub = array_ques.length;
                    auto_select_bin(sub_id, (mid) => 
                    {
                        load_que_from_bin(current_sub, mid);
                    });
                }, 200);
            });
        }, 200);
        setTimeout(() => {
            auto_select_bin(sub_id, (mid) => 
            {
                load_que_from_bin(sub_id, mid);
            });
        }, 100);

        remove_double_subs_few();
        sort_subs_after();
        load_sub_scroll_fnclty();
    }

    function load_ques_in_sub()
    {
            get_ques_by_sub_id(current_sub, function(res)
            {
                if(res == "[]")
                {
                    return;
                }
    
                var ques = JSON.parse(res);
                
                if(ques.length > 0)
                {
                    array_ques = [];
                    $.each(ques, function (index, value) 
                    {
                        if(value != '')
                        {
                            array_ques.push(value);
                        }
                    });
    
                    current_que_in_array = 0;
                    var first_que = array_ques[0];
                }
                else
                {
                    showRedAlert("אין שאלות בנושא זה");
                    $(".qa_continue").off("click");
                }
            });
    }

    function getTotalBins(quiz)
    {
        return new Promise((resolve, reject) => {
            try {
                console.log('Calling total_bins_in_quiz with quiz:', quiz);
                total_bins_in_quiz(quiz, (total_bins) => {
                    console.log('total_bins_in_quiz callback executed, total_bins:', total_bins);
                    if (total_bins !== undefined && total_bins !== null) {
                        resolve(total_bins);
                    } else {
                        reject('total_bins is undefined or null');
                    }
                });
            } catch (err) {
                reject('Exception occurred: ' + err.message);
            }
        });
    }

    function next_que(my_que_id, my_correct)
    {

        getTotalBins(current_quiz).then(total_bins => 
        {
            console.log('total_bins: ', total_bins);
            console.log('current_prog_bar_val: ', current_prog_bar_val);

            var current_prog = current_prog_bar_val;

            console.log('current_prog: ', current_prog)

            get_sub_by_que_id(my_que_id, (sub_id) => 
            {
                get_bin_by_que_id(my_que_id, (my_bin) => 
                {
                    var bin = 0;
                    my_bin = parseInt(my_bin);
                    if(my_correct == '1')
                    {
                        // If answear is correct

                        current_prog += (1 / total_bins) * 100;
                        set_progress_bar(current_prog);

                        get_num_of_bins(sub_id, (nob) => 
                        {
                            if(my_bin == nob)
                            {
                                next_sub();
                                setTimeout(() => {
                                    mark_current_sub();
                                }, 1000);
                            }
                            else
                            {
                                bin = my_bin + 1;
                                current_bin = bin;
                                load_que_from_bin(sub_id, bin);
                            }
                        });
                    }
                    else
                    {
                        // If answear is wrong
                        if(my_bin > 1)
                        {
                            current_prog -= (1 / total_bins) * 100;
                            set_progress_bar(current_prog);
                            bin = my_bin - 1;
                        }
                        else
                        {
                            bin = my_bin;
                            set_progress_bar(current_prog);
                        }
                        current_bin = bin;
                        load_que_from_bin(sub_id, bin);
                    }
                });
            });

            // End of total bins function
        }).catch(error => {
            console.error('Error retrieving total_bins:', error);
        });
        
    }

    function next_bin()
    {
        get_next_bin(current_sub, current_bin, (next_bin) => 
        {
            console.log('cur: ', current_bin, '  nxt: ', next_bin)
            if(next_bin == current_bin)
            {
                // Last bin in subject
                next_sub();
                setTimeout(() => {
                    mark_current_sub();
                }, 1000);
            }
            else
            {
                load_que_from_bin(current_sub, next_bin);
                current_bin = next_bin;
            }
        });
    }

    function previous_bin()
    {
        if(current_bin > 1)
        {
            current_bin = current_bin - 1;
            load_que_from_bin(current_sub, current_bin);
        }

        lower_bin = false;
    }

    function next_sub()
    {
        var cur_sub_in_array = array_subs.indexOf(current_sub);
        var next_sub = parseInt(cur_sub_in_array) + 1;

        if(next_sub <= (num_of_subs_in_quiz - 1))
        {
            // load_subject(array_subs[next_sub]);

            load_sub_click(array_subs[next_sub]);

            // auto_select_bin(current_sub, (mid) => 
            // {
            //     load_que_from_bin(current_sub, mid);
            // });
        }
        else
        {
            end_quiz();
        }
    }

    function load_last_que2()
    {
        get_last_que2((last_que_id) => 
        {
            if(last_que_id == ''){ console.log('empty');return }
            get_sub_by_que_id(last_que_id, (sub_id) => 
            {
                current_sub = sub_id;
                
                setTimeout(() => {
                    mark_current_sub();
                }, 400);

                // load next question instead
                load_question(last_que_id);

                // Loading the last answeared question
                load_sub_click(sub_id);
            });
        });
    }

    function end_quiz()
    {
        content_element.html("");
        content_element.append("נגמר השאלון");
        set_progress_bar(100);
        update_run_data();
        save_user_end_run_data();
        update_quiz_run_end(current_quiz);
        $(".qa_fl2").css('background-color', '#fff');
    }

    function load_quiz_saved_data()
    {
        get_last_corr( (res) => 
        {
            var cor_ques = JSON.parse(res);
            array_correct_ans = [];
            $.each(cor_ques, function (index, value) 
            {
                if(!array_correct_ans.includes(value)){ array_correct_ans.push(value) }
            });
        });

    }

    function get_last_sub(callback)
    {
        $.get("app/actions/quiz-app-action.php?action=get_last_sub&quiz_id="+current_quiz, (res) => { callback(res) });
    }

    function get_last_que(callback)
    {
        $.get("app/actions/quiz-app-action.php?action=get_last_que&quiz_id="+current_quiz, (res) => { callback(res) });
    }

    function get_last_progbar(callback)
    {
        $.get("app/actions/quiz-app-action.php?action=get_last_progbar&quiz_id="+current_quiz, (res) => { callback(res) });
    }

    function get_last_corr(callback)
    {
        $.get("app/actions/quiz-app-action.php?action=get_last_corr&quiz_id="+current_quiz, (res) => { callback(res) });
    }

    function save_user_end_run_data()
    {
        $.get("app/actions/quiz-app-action.php?action=end_quiz&quiz_id="+current_quiz, (res) => {});
    }

    function get_run_quiz_id(callback)
    {
        $.get("app/actions/quiz-app-action.php?action=get_run_quiz_id&quiz_id="+current_quiz, (res) => { callback(res) });
    }

    function save_que_run(que_id, is_correct)
    {
        get_run_quiz_id((res) => 
        {
            if(res != 0)
            {
                $.ajax({
                    type: "GET",
                    url: "app/actions/quiz-app-action.php",
                    data: 
                    {
                        action: 'save_que_run', 
                        que_id: que_id, 
                        is_correct: is_correct, 
                        quiz_run_id: res, 
                        cur_sub_id: current_sub
                    },
                    success: function (response) 
                    {
                        
                    }
                });
            }
        });
        
    }

    function enable_answears()
    {
        $(".qa_ans_fill .qa_anss").css("cursor", "pointer");

        $(".qa_continue").off("click");
        
        $(".qa_continue").click(function()
        {
            check_answear(current_que, selected_ans);
            update_progress_bar();
        });

        $(".qa_anss").click(function()
        {
            var ans_id = $(this).attr("id");
            selected_ans = ans_id;

            // Remove any other marks
            $(".qa_ans_fill .qa_anss").css("box-shadow", "0px 1px 3px 2px #aaa");
            $(".qa_ans_fill .qa_anss").css("background-color", "#fff");
            $(".qa_ans_fill .qa_anss").css("color", "#000");
            $(".qa_ans_fill .qa_anss").css("border", "none");

            // Mark the selected answear
            $(".qa_ans_fill .ans_id_"+selected_ans).css("box-shadow", "0px 1px 3px 2px #0a95d4");
            $(".qa_ans_fill .ans_id_"+selected_ans).css("background-color", "#ddf4ff");
            $(".qa_ans_fill .ans_id_"+selected_ans).css("color", "#0a95d4");
            $(".qa_ans_fill .ans_id_"+selected_ans).css("border", "none");

            // Set the continue button
            $(".qa_continue").css("cursor" ,"pointer");
            $(".qa_continue").css("background-color" ,"#66ae30");
            $(".qa_continue").css("color" ,"#fff");
            $(".qa_continue").css("border" ,".5px solid #66ae30");
            $(".qa_continue").hover(
            function()
            {
                // Mouse in
                $(this).css(
                {
                    "background-color": "#fff", 
                    "color": "#66ae30"
                });
            }, 
            function()
            {
                // Mouse out
                $(this).css(
                {
                    "background-color": "#66ae30", 
                    "color": "#fff"
                });
            });
            
        });
    }

    function disable_answears()
    {
        $(".qa_ans_fill .qa_anss").css("cursor", "default");
        $(".qa_ans_fill .qa_anss").off("click");
    }

    function try_again()
    {
        // Remove marks from answears
        $(".qa_ans_fill .qa_anss").css("box-shadow", "none");
        $(".qa_ans_fill .qa_anss").css("border", "1px solid #000");
        $(".qa_ans_fill .qa_anss").css("color", "#000");
        $(".qa_ans_fill .qa_anss").css("background-color", "#fff");
        
        enable_answears();
        selected_ans = 0;

        // Set the continue button
        $(".qa_continue").text("בדוק תשובה");
        $(".qa_continue").css(
        {
            "background-color": "#222", 
            "border": "1px solid #222", 
            "color": "#fff"
        });
        $(".qa_continue").hover(
            function()
            {
                $(this).css(
                {
                    "background-color": "#fff", 
                    "color": "#222" 
                });
            }, 
            function()
            {
                $(this).css(
                {
                    "background-color": "#222", 
                    "color": "#fff" 
                });
            });
        
        // Reset the button background
        $(".btm_btn_fill").css("background-color", "transparent");
        $(".qa_btn_text").text("");
    }

    function save_user_ans_info(que_id, ans_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'save_user_ans_info', 
                    que_id: que_id, 
                    ans_id: ans_id 
                },
                success: function (response) 
                {
                    
                }
            });
    }

    function save_user_ans_corr_info(que_id, ans_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'save_user_ans_corr_info', 
                    que_id: que_id, 
                    ans_id: ans_id 
                },
                success: function (response) 
                {
                    
                }
            });
    }

    function update_que_diff(que_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'update_que_diff', 
                    que_id: que_id 
                },
                success: function (response) 
                {
                    
                }
            });
    }

    function save_user_run_data()
    {
        var que_id = current_que;
        var sub_id = current_sub;
        var quiz_id = current_quiz;
        var correct = array_correct_ans.length;
        var wrong = array_wrong_ans.length;
        var progressbar = current_prog_bar_val;
        var corr_data = JSON.stringify(array_correct_ans);
        
       $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'save_user_run_data', 
                    que_id: que_id, 
                    sub_id: sub_id, 
                    quiz_id: quiz_id, 
                    correct: correct, 
                    wrong: wrong, 
                    progressbar: progressbar, 
                    array_corr: corr_data
                },
                success: function(response){}
            });
    }

    function update_run_data()
    {
        var que_id = current_que;
        var quiz_id = current_quiz;
        var correct = array_correct_ans.length;
        var wrong = array_wrong_ans.length;
        var session_id = run_session_id;
        var bin = current_bin;
        
        check_session_avlbl(session_id, (res) =>
        {
            if(res == '0')
            {
                $.ajax(
                    {
                        type: "GET",
                        url: "app/actions/quiz-app-action.php",
                        data: 
                        {
                            action: 'update_run_data', 
                            que_id: que_id, 
                            quiz_id: quiz_id, 
                            correct: correct, 
                            wrong: wrong, 
                            session_id: session_id
                        },
                        success: function(response)
                        {
                            save_mistakes(session_id, mistakes);
                        }
                    });
            }
            else
            {
                save_run_data();
            }
        });
    }

    function save_mistakes(session_id, mistakes)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'update_run_data_mistakes', 
                    session_id: session_id, 
                    mistakes: mistakes 
                },
                success: function(response)
                {
                    
                }
            });
    }

    function save_run_data()
    {
        var que_id = current_que;
        var quiz_id = current_quiz;
        var correct = array_correct_ans.length;
        var wrong = array_wrong_ans.length;
        var session_id = run_session_id;
        
        check_session_avlbl(session_id, (res) =>
        {
            if(res == '0')
            {
                update_run_data();
            }
            else
            {
                $.ajax(
                    {
                        type: "GET",
                        url: "app/actions/quiz-app-action.php",
                        data: 
                        {
                            action: 'save_run_data', 
                            que_id: que_id, 
                            quiz_id: quiz_id, 
                            correct: correct, 
                            wrong: wrong, 
                            session_id: session_id, 
                            mistakes: mistakes 
                        },
                        success: function(response)
                        {
                            save_mistakes(session_id, mistakes);
                        }
                    });
            }
        });
    }

    function save_quiz_run(quiz_id)
    {
        $.ajax
        ({
            type: "GET",
            url: "app/actions/quiz-app-action.php",
            data: 
            {
                action: 'save_quiz_run', 
                quiz_id: quiz_id
            },
            success: function(response)
            {
                
            }
        });
    }
    
    function update_quiz_run_end(quiz_id)
    {
        $.ajax
        ({
            type: "GET",
            url: "app/actions/quiz-app-action.php",
            data: 
            {
                action: 'update_quiz_run_end', 
                quiz_id: quiz_id
            },
            success: function(response)
            {
                
            }
        });
    }

    function check_answear(que_id, ans_id)
    {
        if(selected_ans === 0)
        {
            return;
        }
        
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'qa_check_ans', 
                    que_id: que_id, 
                    ans_id: ans_id 
                },
                success: function (response) 
                {
                    disable_answears();

                    if(response == 1)
                    {
                        if(!array_correct_ans.includes(current_que)){ array_correct_ans.push(current_que) }
                        save_user_run_data();
                        update_progress_bar();
                        save_user_ans_corr_info(que_id, ans_id);
                        update_que_diff(que_id);
                        save_que_run(que_id, '1');

                        // Mark the correct answear
                        $(".qa_ans_fill .ans_id_"+selected_ans).css("box-shadow", "#66ae30 0px 1px 6px 3px");
                        $(".qa_ans_fill .ans_id_"+selected_ans).css("border", "1px solid #66ae30");
                        $(".qa_ans_fill .ans_id_"+selected_ans).css("color", "#66ae30");
                        $(".qa_ans_fill .ans_id_"+selected_ans).css("background-color", "#fff");

                        // Set the continue button
                        $(".qa_continue").text("המשך");
                        $(".qa_continue").css("cursor" ,"pointer");
                        $(".qa_continue").css("background-color" ,"#66ae30");
                        $(".qa_continue").css("border-color" ,"#66ae30");
                        $(".qa_continue").css("color" ,"#fff");
                        $(".qa_continue").hover(
                        function()
                        {
                            $(this).css(
                            {
                                "background-color": "#fff", 
                                "color": "#66ae30" 
                            });
                        }, 
                        function()
                        {
                            $(this).css(
                            {
                                "background-color": "#66ae30", 
                                "color": "#fff" 
                            });
                        });

                        $(".qa_continue").off("click");
                        $(".qa_continue").click(function()
                        {
                            // alert('5')
                            // if(it_is_the_last_bin)
                            // {
                            //     alert('6')
                            //     next_bin();
                            // }
                            // else
                            // {
                                // next_que_in_bin();
                                next_que(que_id, '1');
                            // }
                        });

                        // Set the button background
                        $(".btm_btn_fill").css("background-color", "#d6ffb8");
                        $(".qa_btn_text").css("color", "#4a9d00");
                        get_correct_ans(que_id, function(cor)
                        {
                            get_ans_text(cor, function(ans_text)
                            {
                                $(".qa_btn_text").html(
                                    "<div class='tf_ttl_fill'>" + 
                                    "<i class='fa-solid fa-circle-check'></i>&nbsp;&nbsp;" + 
                                    "<b>התשובה שבחרת נכונה.</b>" + 
                                    "</div>"
                                );
                            });
                        });
                    }
                    else
                    {
                        add_mistake();
                        array_wrong_ans.push(current_que);
                        save_user_run_data();
                        update_progress_bar();
                        save_que_run(que_id, '0');

                        // Mark the wrong answear
                        $(".qa_ans_fill .ans_id_"+selected_ans).css("box-shadow", "#E91E63 0px 0px 6px 3px");
                        $(".qa_ans_fill .ans_id_"+selected_ans).css("border", "1px solid #E91E63");
                        $(".qa_ans_fill .ans_id_"+selected_ans).css("color", "#E91E63");
                        $(".qa_ans_fill .ans_id_"+selected_ans).css("background-color", "#fff");

                        // Set the continue button
                        get_que_vid(current_que, function(res)
                        {
                            if(res == '')
                            {
                                $(".qa_continue").text("המשך לשאלה הבאה");
                                $(".qa_continue").off("click");
                                $(".qa_continue").click(function()
                                {
                                    next_que(current_que, '0');
                                });
                            }
                            else
                            {
                                $(".qa_continue").text("צפה בסרטון הסבר");
                                $(".qa_continue").off("click");
                                $(".qa_continue").click(function()
                                {
                                    watch_in_exp_vid(current_que);
                                });
                            }
                        });
                        
                        $(".qa_continue").css(
                        {
                            "cursor": "pointer", 
                            "background-color": "#e91e63", 
                            "border": "1px solid #e91e63", 
                            "color": "#fff"
                        });
                        $(".qa_continue").hover(
                            function()
                            {
                                $(this).css(
                                {
                                    "background-color": "#fff", 
                                    "color": "#e91e63" 
                                });
                            }, 
                            function()
                            {
                                $(this).css(
                                {
                                    "background-color": "#e91e63", 
                                    "color": "#fff" 
                                });
                            });

                        // Set the button background
                        $(".btm_btn_fill").css("background-color", "#ffdfe0");
                        $(".qa_btn_text").css("color", "#ea2b2b");
                        get_correct_ans(que_id, function(cor)
                        {
                            get_ans_text(cor, function(ans_text)
                            {
                                $(".qa_btn_text").html(
                                    "<div class='tf_ttl_fill'>" + 
                                    "<i class='fa-solid fa-circle-xmark'></i>&nbsp;&nbsp;" + 
                                    "<span class='qa_btn_text_ttl'>התשובה שבחרת שגויה.</span>" + 
                                    "</div>" + 
                                    "<br>" + 
                                    "<div class='tf_txt_fill'>" + 
                                    "<b>התשובה הנכונה:&nbsp;</b>" + 
                                    ans_text + 
                                    "</div>"
                                );
                            });
                        });
                        
                    }
                }, 
                error: function(err1, err2, err3)
                {
                    showRedAlert("שגיאה בבדיקת התשובה");
                }
            });
        
        save_user_ans_info(que_id, ans_id);
        update_que_diff(que_id);
        update_run_data();
    }

    window.quiz_loading = function(loading)
    {
        if(loading)
        {
            $(".quiz_in").append("<div class='quiz_loading_filllll'>" + "<div class='loader'></div>" + "</div>");
        }
        else
        {
            $(".quiz_loading_filllll").remove();
        }
    }

    function watch_in_exp_vid(que_id)
    {
        setEscapeKeyEnabled(false);

        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_que_video', 
                    que_id: que_id 
                },
                success: function(response) 
                {
                    $("body").append("<div class='qa_flt_vid_ex'><div class='qa_flt_vid_fill'>" + response + "</div></div>")
                    setTimeout(() => {
                        $(".qa_flt_vid_fill").append("<span class='qa_ev_kg_btn'>המשך לשאלה הבאה</span>");
                        ev_next_que(que_id);
                    }, 3000);
                }
            });
    }

    function get_que_vid(que_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_que_video', 
                    que_id: que_id 
                },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    function ev_next_que(que_id)
    {
        $(".qa_ev_kg_btn").click(function()
        {
            next_que(que_id, '0');
            $(".qa_flt_vid_ex").html("");
            $(".qa_flt_vid_ex").remove(".qa_flt_vid_ex");
            setEscapeKeyEnabled(true);
        });
    }

    function refresh_ques_array(callback)
    {
        get_ques_by_sub_id(current_sub, function(res)
        {
            var ques = JSON.parse(res);
            array_ques = [];
            $.each(ques, function (index, value)
            {
                array_ques.push(value);
            });
            array_ques.sort(function(a, b){ return a - b; });
            num_of_ques_in_sub = array_ques.length;
            callback(num_of_ques_in_sub);
        });
    }

    function load_que_from_bin(sub_id, bin)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/quiz-app-action.php",
            data: 
            { 
                action: 'load_que_from_bin', 
                sub_id: sub_id, 
                bin: bin 
            },
            success: function(res)
            {
                if(res != '0')
                {
                    load_question(res);
                }
            }
        });
    }

    function get_next_bin(sub_id, bin, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/quiz-app-action.php",
            data: 
            { 
                action: 'get_next_bin', 
                sub_id: sub_id, 
                bin: bin 
            },
            success: function(res)
            {
                callback(res);
            }
        });
    }
    
    function auto_select_bin(sub_id, callback)
    {
        get_num_of_bins(sub_id, function(nob)
        {
            refresh_ques_array(function(num_of_ques_in_sub)
            {
                var mid = nob / 2;
                mid = Math.round(mid + 0.2);
                if (mid === 0){ mid = 1; }
                current_bin = mid;
                callback(mid);
            });
        });
    }

    function get_num_of_bins(sub_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_num_of_bins', 
                    sub_id: sub_id 
                },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    function mark_current_sub()
    {
        $(".qa_subject").css("border", ".5px solid #000");
        $(".qa_subject_"+current_sub).css("border", "2px solid #3498db");
        
        get_sub_text(current_sub, function(sub_text)
        {
            $(".btm_sub_nm").text(sub_text);
            load_flip_funclty();
        });
    }

    function get_correct_ans(que_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_correct_ans', 
                    que_id: que_id 
                },
                success: function (response) 
                {
                    callback(response);
                }
            });
    }

    function get_ans(que_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_ans', 
                    que_id: que_id 
                },
                success: function (response) 
                {
                    callback(response);
                }
            });
    }

    function it_is_the_last_bin()
    {
        if((current_bin + 1) > num_of_bins)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    window.load_question = function(que_id)
    {
        reset_question_data();
        current_que = que_id;
        //save_run_data();
        save_user_run_data();
        save_quiz_run(current_quiz);

        get_num_of_bins(current_sub,(res)=>{ num_of_bins = parseInt(res) });

        setTimeout(() => {
            var bin_color = get_bin_color(num_of_bins, current_bin);
            $(".qa_fl2").css(
            {
                'background-color': bin_color, 
                'transition': 'background-color .7s'
            });
        }, 300);

        $(".qa_ans_fill").html("");
        $(".qa_continue").text("בדוק תשובה");
        
        get_que_text(que_id, function(res)
        {
            $(".qa_que").text(res);
        });

        get_num_of_ans(que_id, function(res)
        {
            $(".qa_ans_fill").html("");
            for(var i = 1; i <= res; i++)
            {
                $(".qa_ans_fill").append('<span class="qa_ans' + i + ' qa_anss"></span>');
            }
            load_answears(que_id);
            mix_the_answears();
            enable_answears();
        });

        setTimeout(() => {
            update_progress_bar();
            load_sub_scroll_fnclty();
        }, 500);

    }
    
    function load_correct_ans(que_id)
    {
        get_correct_ans(que_id, function(ans_id)
        {
            get_ans_text(ans_id, function(ans_text)
            {
                $(".qa_ans1").text(ans_text);
                $(".qa_ans1").attr("id", ans_id);
                $(".qa_ans1").addClass("ans_id_" + ans_id);
            });
        });
    }

    function load_answears(que_id)
    {
        get_ans(que_id, function(res)
        {
            var answears = JSON.parse(res);
    
            $.each(answears, function (index, value) 
            { 
                var el = $(".qa_ans"+(parseInt(index)+2));
                get_ans_text(value, function(res)
                {
                    el.text(res);
                    fix_ans_direction();
                    fix_que_direction()

                    // Make sure that the text direction fixed after the answears are loaded
                    setTimeout(() => {
                        fix_ans_direction();
                        fix_que_direction()
                    }, 500);
                    setTimeout(() => {
                        fix_ans_direction();
                        fix_que_direction()
                    }, 1500);
                    setTimeout(() => {
                        fix_ans_direction();
                        fix_que_direction()
                    }, 2500);
                    setTimeout(() => {
                        fix_ans_direction();
                        fix_que_direction()
                    }, 3500);
                });
                el.attr("id", value);
                el.addClass("ans_id_" + value);
            });
        });

        load_correct_ans(que_id);
    }

    function fix_que_direction()
    {
        var curr_ans_txt = $(".qa_que").text();
        if(curr_ans_txt != '')
        {
            var dir = txt_direction(curr_ans_txt);
            $(".qa_que").css("direction", dir);
        }
    }

    function fix_ans_direction()
    {
        for(var i = 1; i <= 7; i++)
        {
            var curr_ans_txt = $(".qa_ans"+i).text();
            if(curr_ans_txt != '')
            {
                var dir = txt_direction(curr_ans_txt);
                $(".qa_ans"+i).css("direction", dir);
            }
        }
    }

    function get_num_of_ans(que_id, callback)
    {
        var num_of_ans = 0;
        get_ans(que_id, function(res)
        {
            if(res != "[]" && res.startsWith("["))
            {
                var answears = JSON.parse(res);
                num_of_ans = answears.length;
                num_of_ans++;
                callback(num_of_ans);
            }
            else
            {
                // no answears for this question
            }
        });
    }

    function mix_the_answears()
    {
        var parent_el = $(".qa_ans_fill");
        var ans_el = parent_el.children().get();

        for(var i = 0; i <= 5; i++)
        {
            ans_el.sort(function()
            {
                return 0.5 - Math.random();
            });

            $.each(ans_el, function(idx, item)
            {
                parent_el.append(item);
            });
        }
    }

    function set_progress_bar(value)
    {
        $(".pb_inside").css("width", value + "%");
        current_prog_bar_val = value;
    }

    // function get_progress_bar()
    // {
    //     return $(".pb_inside").width();
    // }

    function get_num_of_subs_by_quiz_id(quiz_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_num_of_subs_by_quiz_id', 
                    quiz_id: quiz_id 
                },
                success: function (response) 
                {
                    callback(response);
                }
            });
    }

    function get_num_of_ques_in_quiz(callback) 
    {
        var nos = array_subs.length;
        var no_q = 0;
        var completedRequests = 0;
    
        for(var i = 0; i < nos; i++)
        {
            var c_s = array_subs[i];
            get_ques_by_sub_id(c_s, function(res) 
            {
                completedRequests++;
                if(res != '[]') 
                {
                    var par = JSON.parse(res);
                    var loc_ar = [];
                    $.each(par, function (index, value) 
                    {
                        loc_ar.push(value);
                    });
                    no_q += loc_ar.length;
                } 
                else 
                {
                    // empty subject
                }
                
                // Check if all asynchronous calls are completed
                if(completedRequests === nos) 
                {
                    callback(no_q);
                }
            });
        }

        $.each(array_subs, function(index, value) 
            { 
                get_ques_by_sub_id(array_subs[index], function(res)
                {
                    if(res == "[]")
                    {
                        return;
                    }
                    var ques = JSON.parse(res);
                    if(ques.length > 0)
                    {
                        $.each(ques, function (index, value) 
                        {
                            if(!array_all_ques.includes(value))
                            {
                                array_all_ques.push(value);
                                array_all_ques.sort(function(a, b)
                                {
                                    return a - b;
                                });
                            }
                        });
                    }
                });
            });
    }

    function sort_subs_elements()
    {
        var fill = $(".qa_subs_scroll_container");
        var subs_el = fill.children('div');
        var el_array = subs_el.toArray();
        el_array.sort(function(a, b)
        {
            var aId = parseInt($(a).attr('id'), 10);
            var bId = parseInt($(b).attr('id'), 10);
            return aId - bId;
        });

        $.each(el_array, function(index, value)
        {
            fill.append(value);
        });
        
        $('.qa_subs_scroll_container').scrollLeft(0);
    }
    
    function update_progress_bar()
    {
        get_num_of_ques_in_quiz(function(noqiq)
        {
            var arr1_unique = new Set(array_correct_ans);
            var arr2_unique = new Set(array_wrong_ans);
            var arr1_count = arr1_unique.size;
            var arr2_count = arr2_unique.size;
            var calc = ((arr1_count + arr2_count) / (noqiq / 2)) * 100;

            calc = Math.round(calc);

            if(arr1_count > 0)
            {
                if(calc > 100)
                {
                    calc = 100;
                }
                // set_progress_bar(calc);
            }
            
        });
        setTimeout(() => {
            quiz_loading(false);
        }, 800);
    }

    function get_ques_by_sub_id(sub_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'get_ques_by_sub_id', 
                    sub_id: sub_id 
                },
                success: function (response) 
                {
                    callback(response);
                }
            });
    }

    function get_subs_by_quiz_id(quiz_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'qa_get_subs', 
                    quiz_id: quiz_id 
                },
                success: function (response) 
                {
                    callback(response);
                }
            });
    }

    function add_mistake()
    {
        mistakes++;
        load_mistakes();
    }

    $('body').append('<div class="m10mis">טעית ב10 שאלות או יותר.' + 
                     '<br>עליך להתחיל את השאלון מההתחלה.<br>' + 
                     '<button id="rest_ok_btn">אוקיי</button></div>');
    
    $(".m10mis").hide();

    $("#rest_ok_btn").click(() => 
    {
        $(".m10mis").hide();
    });

    function load_mistakes()
    {
        
        $("#qa_mist_count").html(mistakes);

        setTimeout(() => {
            if(mistakes >= 10)
            {
                $(".m10mis").show();
                restart_quiz();
            }
        }, 500);
    }

    window.flip_n_load = function()
    {
        load_sub_txt(current_sub, function(res)
        {
            $('.quiz_in').css(
                {
                    'transition': 'transform 0.6s', 
                    'transform-style': 'preserve-3d', 
                    'transform': 'rotateY(180deg)'
                });
                setTimeout(() => {
                    $('.quiz_in').html('<span class="qa_sub_txt_fl">' + res + '</span>');
                }, 50);
        });
    }

    function load_sub_txt(sub_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-app-action.php",
                data: 
                {
                    action: 'load_sub_txt', 
                    sub_id: sub_id 
                },
                success: function (response) 
                {
                    callback(response);
                }
            });
        
    }

    function txt_direction(text)
    {
        var he_chars = /[\u0590-\u05FF]/;
        var en_chars = /[a-zA-Z]/;
        var numbers = /[0-9999999999]/;

        var dir = 'ltr';
        
        if(he_chars.test(text))
        {
            dir = 'rtl';
            return dir;
        }
        else if(numbers.test(text))
        {
            dir = 'ltr';
            return dir;
        }
        else if(en_chars.test(text))
        {
            dir = 'ltr';
            return dir;
        }
        else
        {
            return dir;
        }
    }

    function restart_quiz()
    {
        array_correct_ans = [];
        array_wrong_ans = [];
        load_subject(array_subs[0]);
        set_progress_bar(1);
        mistakes = 0;
        load_mistakes();
    }

    function remove_double_subs()
    {
        var seenIds = {};

        $('.qa_subs_scroll_container').children().each(function() 
        {
            var id = $(this).attr('id');

            if(seenIds[id]) 
            {
                $(this).remove();
            } 
            else 
            {
                seenIds[id] = true;
            }
        });
    }

    function remove_double_subs_few()
    {
        remove_double_subs();
        sort_subs_after();

        setTimeout(() => {
            remove_double_subs();
            sort_subs_after();
            $('.qa_subs_scroll_container').scrollLeft(0);
        }, 500);
        setTimeout(() => {
            remove_double_subs();
            sort_subs_after();
            $('.qa_subs_scroll_container').scrollLeft(0);
        }, 1500);
        setTimeout(() => {
            remove_double_subs();
            sort_subs_after();
            $('.qa_subs_scroll_container').scrollLeft(0);
        }, 2500);
        setTimeout(() => {
            sort_subs_after();
            $('.qa_subs_scroll_container').scrollLeft(0);
        }, 4000);
    }

    function sort_subs_after()
    {
        var container = $(".qa_subs_scroll_container");
        var elements = container.children();
        
        elements.sort(function(a, b)
        {
            var idA = $(a).attr('id');
            var idB = $(b).attr('id');
            return idA.localeCompare(idB);
        });

        container.empty().append(elements);
        $(".qa_subject").off("click");
        $(".qa_subject").click(function()
        {
            var sub_id = $(this).attr("id");
            load_sub_click(sub_id);
            load_sub_scroll_fnclty();
        });
    }

    function change_bin_color(num_of_bins, current_bin)
    {
        var bin_color = get_bin_color(num_of_bins, current_bin);
        $(".qa_fl2").css(
        {
            'background-color': bin_color, 
            'transition': 'background-color .7s'
        });
    }

    function load_sub_click(sub_id)
    {
        get_num_of_bins(sub_id, (nob_global) => 
        {

            current_sub = sub_id;
            mark_current_sub();
            load_ques_in_sub();
            $(".on_top_of_when_finish").remove();
            get_last_run_quiz_id((last_run_id) => 
            {
                if(last_run_id == '0')
                {
                    auto_select_bin(sub_id, (mid) => 
                    {
                        current_bin = mid;
                        load_que_from_bin(current_sub, mid);
                        change_bin_color(nob_global, mid);
                        console.log('0');
                    });
                }
                else
                {
                    get_last_ansed_que_in_sub(last_run_id, (res) => 
                    {
                        if(res == '')
                        {
                            auto_select_bin(sub_id, (mid) => 
                            {
                                current_bin = mid;
                                load_que_from_bin(current_sub, mid);
                                change_bin_color(nob_global, mid);
                                console.log('1');
                            });
                        }
                        else
                        {
                            var data = JSON.parse(res);
                            var my_que_id = '';
                            var my_correct = '';

                            $.each(data, function (index, value) 
                            {
                                if(index == 0)
                                {
                                    my_que_id = value;
                                    // alert("que_id: "+my_que_id)
                                }
                                if(index == 1)
                                {
                                    my_correct = value;
                                    // alert("correct: "+my_correct)
                                }
                            });
                            
                            get_bin_by_que_id(my_que_id, (my_bin) => 
                            {
                                var bin = 0;
                                my_bin = parseInt(my_bin);
                                if(my_correct == '1')
                                {
                                    // If answear is correct
                                    get_num_of_bins(sub_id, (nob) => 
                                    {
                                        if(my_bin == nob)
                                        {
                                            $(".qa_qna_fill").append('<div class="on_top_of_when_finish">'+'סיימת את הנושא!'+'</div>');
                                            var sub_height = $(".qa_subject_fill").outerHeight(true);
                                            var btm_sub_height = parseInt($(".bottom_sub_fill").outerHeight(true));
                                            var qa_fill_height = parseInt($(".qa_qna_fill").outerHeight(true));
                                            $(".on_top_of_when_finish").css(
                                                {
                                                    'margin-top': sub_height, 
                                                    'height': qa_fill_height
                                                });
                                        }
                                        else
                                        {
                                            bin = my_bin + 1;
                                            current_bin = bin;
                                            load_que_from_bin(sub_id, bin);
                                            change_bin_color(nob_global, bin);
                                        }
                                    });
                                }
                                else
                                {
                                    // If answear is wrong
                                    if(my_bin > 1)
                                    {
                                        bin = my_bin - 1;
                                    }
                                    else
                                    {
                                        bin = my_bin;
                                    }
                                    current_bin = bin;
                                    load_que_from_bin(sub_id, bin);
                                    change_bin_color(nob_global, bin);
                                    console.log('3');
                                }
                            });
                        }
                    });

                }
            });
        });
    }

    window.get_bin_by_que_id = function(que_id, callback)
    {
        $.get("app/actions/quiz-app-action.php?action=get_bin_by_que_id&que_id="+que_id, (res) => { callback(res) });
    }

    function get_last_ansed_que_in_sub(run_id, callback, sub_id='')
    {
        if(sub_id == '')
        {
            sub_id = current_sub;
        }
        $.get("app/actions/quiz-app-action.php?action=get_last_ansed_que_in_sub&run_id="+run_id+"&sub_id="+sub_id, (res) => { callback(res) });
    }

    function get_last_run_quiz_id(callback)
    {
        $.get("app/actions/quiz-app-action.php?action=get_last_run_quiz_id&current_quiz="+current_quiz, (res) => { callback(res) });
    }

    function get_last_bin_in_sub(sub_id, callback)
    {
        $.get("app/actions/quiz-app-action.php?action=get_last_bin_in_sub&sub_id="+sub_id+"&quiz_id="+current_quiz, 
            (res) => { callback(res) });
    }

    window.subject_summery = function()
    {
        $.get("layout/quiz-app/summary.php?sub_id="+current_sub, (res) => 
        {
            content_element.append('<div class="subject_summery">'+res+'</div>');
            load_flip_funclty();
        });
    }

    window.remove_subject_summary = function()
    {
        $(".subject_summery").remove();
        load_flip_funclty();
    }

    window.get_last_que2 = function(callback)
    {
        get_run_quiz_id((res) => 
        {
            $.get("app/actions/quiz-app-action.php?action=get_last_que2&run_quiz_id="+res, (res22) => { callback(res22) });
        });
    }

    window.load_sub_scroll_fnclty = function()
    {
        $('.right-btn').off('click');
        $('.right-btn').click(function() 
        {
            var currentPosition = $('.qa_subs_scroll_container').scrollLeft();
            $('.qa_subs_scroll_container').animate({ scrollLeft: currentPosition + scrollAmount }, 100);
        });

        $('.left-btn').off('click');
        $('.left-btn').click(function() 
        {
            var currentPosition = $('.qa_subs_scroll_container').scrollLeft();
            $('.qa_subs_scroll_container').animate({ scrollLeft: currentPosition - scrollAmount }, 100);
        });
    }

    load_sub_scroll_fnclty();

    setInterval(() => {
        load_sub_scroll_fnclty();
    }, 2000);

    $(".qa_continue").off("click");
    $(".qa_continue").click(function()
    {
        check_answear(current_que, selected_ans);
    });

    $(".qa_tb_close").click(function()
    {
        close_quiz_popup();
    });

    window.load_flip_funclty = function()
    {
        $(".btm_sub_nm").off('click');
        $(".bottom_sub_fill .btm_sub_nm").click(function()
        {
            subject_summery();
        });
    }

    function get_bin_color(num_of_bins, bin)
    {
        var partSize = num_of_bins / 3;

        if (bin <= partSize) 
        {
            return '#008000'; //red
        } 
        else if (bin <= 2 * partSize) 
        {
            return '#FFA500'; //orange
        } 
        else 
        {
            return '#e05656'; //green
        }
    }

    load_flip_funclty();

    setTimeout(() => {
        load_flip_funclty();
    }, 500);
    setTimeout(() => {
        load_flip_funclty();
    }, 1500);
    setTimeout(() => {
        load_flip_funclty();
    }, 2500);
    setTimeout(() => {
        load_flip_funclty();
    }, 3500);

    
});