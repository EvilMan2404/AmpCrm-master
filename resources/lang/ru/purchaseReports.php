<?php

return [
    'title'          => 'Отчетность по закупкам',
    'id'             => 'ID',
    'name'           => 'Название',
    'date_start'     => 'Начало',
    'date_finish'    => 'Конец',
    'wastes'         => 'Затраты',
    'total_lots'     => 'Затраты лоты',
    'stocks'         => 'Лоты',
    'total_waste'    => 'Затраты доп',
    'total'          => 'Итоговые затраты',
    'created at'     => 'Создано',
    'updated at'     => 'Обновлено',
    'deleted at'     => 'Удалено',
    'action'         => 'Действия',
    'create'         => 'Создать отчет',
    'save'           => 'Успешно сохранено',
    'deleted'        => 'Успешно удалено',
    'edit'           => 'Редактирование отчета',
    'main-info'      => 'Обзор',
    'details'        => 'Детали',
    'cancel'         => 'Отмена',
    'createLotStock' => 'Создать отчет',
    'owner'          => 'Пользователь',
    'user_id'        => 'Пользователь',
    'table'          => [
        'nameStock'  => 'Название лота',
        'nameWaste'  => 'Название растраты',
        'wasteSum'   => 'Сумма растраты',
        'totalStock' => 'Растраты на лот',
        'summary'    => 'Итого',
    ],
    'search'         => [
        'start'       => 'Введите хотя-бы 1 символ...',
        'noResults'   => 'Записей с таким названием нет',
        'searching'   => 'Поиск...',
        'searchName'  => 'Введите название',
        'searchOwner' => 'Введите ФИО',
        'waste'       => 'Выберите тип растраты',
    ],
    'errors'         => [
        'name'        => 'Заполните это поле',
        'required'    => 'Заполните это поле',
        'stocks'      => 'Выберите хотя-бы один лот',
        'date_format' => 'Введите валидную дату',
        'date'        => 'Введите валидную дату',
        'wastes'      => 'Введите валидные суммы растрат!',
        'exists'      => 'Введите валидные данные',
        'numeric'     => 'Введите валидные данные',
    ]
];
