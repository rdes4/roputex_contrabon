

var arr_tabs = {
    "MD_1" : {
        'name' : 'Data Customer',
        'icon' : '<i class="fa fa-smile-o"></i>',
    },
    "MD_2" : {
        'name' : 'Data Bank',
        'icon' : '<i class="fa fa-credit-card"></i>'
    },
    "MD_3" : {
        'name' : 'Data Sales',
        'icon' : '<i class="fa fa-list-alt"></i>'
    },
    "T_1" : {
        'name' : 'List',
        'icon' : '<i class="fa fa-file-text"></i>',
    },
    "T_2" : {
        'name' : 'Buat',
        'icon' : '<i class="fa fa-plus"></i>'
    },
    "T_3" : {
        'name' : 'Edit',
        'icon' : '<i class="fa fa-pencil"></i>'
    }
}
var tabs = []

var list_tab = $('.list_tab')
var list_tab_content = $('.list_tab_content')

function openTabs(ele) {
    var id_tab = $(ele).attr('data-id_tab')

    // cek apakah id_tab sudah ada??
    if (!tabs.includes(id_tab)) {
        tabs.push(id_tab);

        var tab_detail = arr_tabs[id_tab]

        list_tab.find('.active').removeClass('active');
        list_tab_content.find('.active').removeClass('show')
        list_tab_content.find('.active').removeClass('active')

        list_tab.append(`
            <li class="nav-item tab_id_${id_tab}">
                <a class="nav-link nav-border active tab-light pt-0" id="list-tab" data-bs-toggle="tab" href="#tab_${id_tab}" role="tab" aria-controls="list" aria-selected="true">
                    ${tab_detail.icon} ${tab_detail.name} <i class="icon-close text-danger float-end me-0 ms-3" onclick='closeTabs("${id_tab}")'></i>
                </a>
            </li>
        `)

        $.post(main_url + '/get-tab-html',
        {
            _token: token,
            id_tab
        },
        function(data, status){
            var html = ''
            html += data
            list_tab_content.append(`
                <div class="tab-pane show active fade tab_content_id_${id_tab}" id="tab_${id_tab}" role="tabpanel" aria-labelledby="list-tab">
                    <div class="card">
                        <div class="card-body">
                            ${html}
                        </div>
                    </div>
                </div>
            `)
        })
    }

}

function closeTabs(id_tab) {

    tabs = tabs.filter(val => val != id_tab);
    list_tab.find(`li.tab_id_${id_tab}`).remove()
    list_tab_content.find(`div.tab_content_id_${id_tab}`).remove()

}
