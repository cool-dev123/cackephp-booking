const MAIN_URL = BASE_URL + "utilisateurs/";
const TYPING_DONE_INTERVAL = 2000;  //time in ms, 5 seconds for example
const STATUS_READ   = 1;
const STATUS_UNREAD = 0;
const STATUS_ARCHIVED     = 1;
const STATUS_NOT_ARCHIVED = 0;

const messagesPage = {
    selectedFilters: [],
    membersSearch: '',
    messagesSearch: '',
    selectedMemberId: '',
    typingTimer: null, //timer identifier
    load: function() {
        const self = this;
        $('.preloader').removeClass('hidden');
        $('.content__body').addClass('hidden');
        $('.no-result').addClass('hidden');
        $('.main').removeClass('py-5');
        $('#bottom-first').addClass('hidden');
        $('#bottom').addClass('hidden');

        $.ajax({
            type: "GET",
            url: MAIN_URL + "getchats?selectedMessageId=" + (+selectedMessageId) + "&filter=" + self.selectedFilters + "&search=" + self.membersSearch,
            success:function(resp) {
                let response = JSON.parse(resp);
                if (response.html) {
                    $('.chats-list').html(response.html).removeClass('hidden');
                    $('.content__body').removeClass('hidden');
                    $('.content__column-right').removeClass('hidden');
                    self.initEvents();
                } else {
                    $('.no-result').removeClass('hidden');
                    $('.content__body').removeClass('hidden');
                    $('.content__column-right').addClass('hidden');
                    $('.chats-list').addClass('hidden');
                }

                if (selectedMessageId) {
                    window.history.pushState( {} , '', window.location.origin + window.location.pathname);
                    const element = document.getElementById(selectedMessageId);

                    if (element) {
                        element.scrollIntoView();
                    }
                }
                
                $('.preloader').addClass('hidden');
            }
        });
    },
    initEvents: function() {
        const self = this;
        const chatColumnMembers = document.querySelector('.content__column-left');

        // members menu
        const openBurgerButton = document.querySelector('.messages-burger'),
              closeBurgerMenu = document.querySelector('.members-burgerClose');

        openBurgerButton.addEventListener('click', () => {
            chatColumnMembers.classList.add('_active');
        });

        closeBurgerMenu.addEventListener('click', () => {
            chatColumnMembers.classList.remove('_active');
        });

        // select a member
        const members = document.querySelectorAll('.members-member');

        document.querySelector('.chats-list').addEventListener('click', (e) => {
            if (!e.target.classList.contains('member__btn') && !e.target.classList.contains('membSelect__item')) {
                members.forEach(element => {
                    element.classList.remove('_active');
                });
                if (!e.target.classList.contains('members-burgerClose')) {
                    if (!e.target.classList.contains('members-member')) {
                        e.target.closest('.members-member').classList.add('_active');
                    } else {
                        e.target.classList.add('_active');
                    }
                }
                $('.members-burgerClose').trigger('click');

                self.messagesSearch = '';
                self.getMessages();
            }
        });

        $('.archive-opt').off('click').on('click', function (e) {
            e.preventDefault();
            self.changeArchived($(e.target).closest('.members-member'), $(e.target).hasClass('not-archived') ? STATUS_ARCHIVED : STATUS_NOT_ARCHIVED);
        });

        $('.read-opt').off('click').on('click', function(e) {
            e.preventDefault();
            self.changeReadStatus($(e.target).closest('.members-member'), $(e.target).hasClass('not-read') ? STATUS_READ : STATUS_UNREAD);
        });

        $('#members-search').off('keyup').on('keyup', function(e) {
            clearTimeout(self.typingTimer);
            self.typingTimer = setTimeout(function() {
                console.log("members-search : ", $(e.target).val());
                self.membersSearch = $(e.target).val();
                self.load();
            }, TYPING_DONE_INTERVAL);
        });

        self.getMessages();
    },
    initLeftEvents: function () {
        const self = this;

        $('.messages__btn').off('click').on('click', function () {
            self.addMessage();
        });

        $('#textarea').off('keydown').on('keydown', function (e) {
            if (e.keyCode == 13 && !e.shiftKey) {
                self.addMessage();
            }
        });

        $('#messages-search').off('keyup').on('keyup', function (e) {
            clearTimeout(self.typingTimer);
            self.typingTimer = setTimeout(function () {
                self.messagesSearch = $(e.target).val();
                self.load();
            }, TYPING_DONE_INTERVAL);
        });
    },
    getActiveMember: function () {
        const activeMemeber = $('.members-member._active');
        return {
            elem: activeMemeber,
            id_message: +activeMemeber.attr('id'),
            user_id: +activeMemeber.attr('data-user_id')
        };
    },
    getMessages: function () {
        const self = this;
        const activeMemeber = self.getActiveMember();
        const messagesBlock = $('.content__column-right');
        // const messagesBody = $('.messages__body');
        const preloader = $('.preloader');

        preloader.removeClass('hidden');
        messagesBlock.addClass('hidden');

        if (activeMemeber) {
            $.ajax({
                type: "GET",
                url: MAIN_URL + "detailmessage/" + activeMemeber.id_message + '?search=' + self.messagesSearch,
                success: function (resp) {
                    let messages = JSON.parse(resp);
                    messagesBlock.html(messages.html);
                    messagesBlock.find('.message__title').html(activeMemeber.elem.find('.member__title').text());
                    preloader.addClass('hidden');
                    messagesBlock.removeClass('hidden');

                    const messagesBody = $('.messages__body');
                    messagesBody.get(0).scrollTop = messagesBody.get(0).scrollHeight;

                    window.scrollTo(0, 0);
                    self.initLeftEvents();
                    self.changeMemeberContentByReadStatus(activeMemeber.elem, STATUS_READ);
                }
            });
        }
    },
    // add message
    addMessage: function () {
        const self = this;
        const txt = $('#textarea').val().trim();
        const msgBtn = $('.messages__btn');
        msgBtn.attr('disabled', 'disabled');

        if (txt) {
            const activeMemeber = self.getActiveMember();

            $.ajax({
                type: "POST",
                url: MAIN_URL + "repondremessageprop/",
                dataType: 'json',
                data: { reponse: txt, idmessage: activeMemeber.id_message, user_id: activeMemeber.user_id },
                success: function (resp) {
                    if (resp.idmessage) {
                        $('#textarea').val('');
                        self.getMessages();
                    }
                }
            });
        }
        msgBtn.removeAttr('disabled');
    },
    changeArchived: function (elem, changeTo = 0) {
        const self = this;

        elem.addClass('disabled');
        $('.preloader').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: MAIN_URL + "changearchived/",
            dataType: 'json',
            data: { archived_value: changeTo, idmessage: elem.attr('id') },
            success: function (resp) {
                self.load();
                $('.content-members').get(0).scrollTop = 0;
                window.scrollTo(0, 0);
                elem.removeClass('disabled');
            }
        });
    },
    changeReadStatus: function (elem, changeTo = 0) {
        const self = this;
        $('.preloader').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: MAIN_URL + "changereadstatus/",
            dataType: 'json',
            data: { read_status_value: changeTo, idmessage: elem.attr('id') },
            success: function (resp) {
                self.changeMemeberContentByReadStatus(elem, changeTo);
                $('.content-members').get(0).scrollTop = 0;
                window.scrollTo(0, 0);
            }
        });
    },
    filter: function (val) {
        const self = this;
        $('.preloader').removeClass('hidden');
        $(document).click();
        if (typeof val !== 'undefined') {
            var index = self.selectedFilters.indexOf(val);
            if (index !== -1) {
                self.selectedFilters.splice(index, 1);
            } else {
                self.selectedFilters.push(val);
            }
        } else {
            self.selectedFilters = [];
        }

        self.load();
    },
    changeMemeberContentByReadStatus: function (elem, readStatus = 0) {
        const self = this;
        const readLabel = elem.find('.read-label');
        const readOption = elem.find('.read-opt');

        $('.preloader').addClass('hidden');

        switch (readStatus) {
            case STATUS_READ:
                elem.removeClass('font-weight-bold');
                readLabel.text(readText);
                readOption.removeClass('not-read').addClass('read')
                readOption.text(notReadOptionTxt);
                break;
            case STATUS_UNREAD:
                elem.addClass('font-weight-bold');
                readLabel.text(notReadText);
                readOption.removeClass('read').addClass('not-read')
                readOption.text(readOptionTxt);
                break;
        }
    },
}

$(document).ready(function () {
    $('#chat_filter').multiselect({
        buttonClass: 'btn filter-btn',
        buttonWidth: 'max-content',
        numberDisplayed: 1,
        includeSelectAllOption: false,
        nonSelectedText: nonSelectedText,
        nSelectedText: nSelectedText,
        allSelectedText: allSelectedText,
        optionClass: function (element) {
            if ($(element).val() == 4) {
                return 'separator';
            }
        },
        onSelectAll: function () {
            messagesPage.filter();
        },
        onDeselectAll: function () {
            messagesPage.filter();
        },
        onChange: function (option, checked, select) {
            messagesPage.filter(option.val());
        }
    });

    messagesPage.load();
});

