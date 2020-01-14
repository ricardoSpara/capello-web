const mdApprove = function(url, id) {
    $(id).find('#linkRoute').attr('href', url);
    $(id).modal('show');
}

const like = function(id, element, reload=false) {
    let icon = $(element).children()[0];
    $.ajax({
        url: `/like/${id}`,
        method: 'GET',
        success: function(res) {
            console.log(res);
            if(res.status == 'liked') {
                $(icon).css('color', '#0073b7');
                $(icon).next('span').css('color', '#0073b7');
                $(icon).removeClass('fa-thumbs-o-up');
                $(icon).addClass('fa-thumbs-up');
                $(element).tooltip('hide');
                $(element).attr('data-original-title', 'Desfazer');
                $(icon).next('span').html('Desfazer');
            } else if(res.status == 'unliked') {
                $(icon).css('color', '');
                $(icon).next('span').css('color', '');
                $(icon).removeClass('fa-thumbs-up');
                $(icon).addClass('fa-thumbs-o-up');
                $(element).tooltip('hide');
                $(element).attr('data-original-title', 'Curtir');
                $(icon).next('span').html('Curtir');
            }
            if(reload) {
                location.reload();
            }
        }
    });
}