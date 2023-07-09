<style>
    .timeline-steps {
        display: flex;
        justify-content: center;
        flex-wrap: wrap
    }

    .timeline-steps .timeline-step {
        align-items: center;
        display: flex;
        flex-direction: column;
        position: relative;
        margin: 1rem
    }

    @media (min-width:768px) {
        .timeline-steps .timeline-step:not(:last-child):after {
            content: "";
            display: block;
            border-top: .25rem dotted gray;
            width: 3.46rem;
            position: absolute;
            left: 7.5rem;
            top: .3125rem
        }
        .timeline-steps .timeline-step:not(:first-child):before {
            content: "";
            display: block;
            border-top: .25rem dotted gray;
            width: 3.8125rem;
            position: absolute;
            right: 7.5rem;
            top: .3125rem
        }
    }

    .timeline-steps .timeline-content {
        width: 10rem;
        text-align: center
    }

    .timeline-steps .timeline-content .inner-circle {
        border-radius: 1.5rem;
        height: 1rem;
        width: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #3b82f6;
    }

    .timeline-steps .timeline-content .inner-circle:before {
        content: "";
        background-color: gray;
        display: inline-block;
        height: 3rem;
        width: 3rem;
        min-width: 3rem;
        border-radius: 6.25rem;
        opacity: .2
    }
</style>
<div class="container">                      
    <div class="row text-center justify-content-center mb-5 mt-5">
        <div class="col-12">
            <h4 class="font-weight-bold">Evolução do Empreendimento</h4>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                <?php foreach ($model->fases as $fase): ?>
                    <?php 
                    $innerBg = "";
                        switch ($fase->status) {
                            case 'Aprovado': $innerBg = "bg-success"; break;
                            case 'Em andamento': $innerBg = "bg-warning"; break;
                            case 'Reprovado': $innerBg = "bg-danger"; break;
                        }    
                    ?>
                    <div class="timeline-step">
                        <div 
                            class="timeline-content" 
                            data-toggle="tooltip"
                            data-placement="top"
                            data-trigger="hover"
                            title="<?php
                            echo $fase->exigencias;
                            ?>"
                            data-original-title="2003"
                        >
                            <div class="inner-circle <?=$innerBg?>"></div>
                            <p class="h6 mt-3 mb-1"><?=date('d/m/Y', strtotime($fase->data))?></p>
                            <p class="h6 text-muted mb-0 mb-lg-0"><?=$fase->fase?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="timeline-step mb-0">
                    <div class="timeline-content" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Sistema Fechado" data-original-title="2020">
                        <div class="inner-circle"></div>
                        <p class="h6 mt-3 mb-1">Conclusão</p>
                    </div>
                    <p><center><?=$model->titulo?></center></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $js = <<<SCRIPT
    /* To initialize BS3 tooltips set this below */
    $(function () { 
        $("[data-toggle='tooltip']").tooltip(); 
    });;
    /* To initialize BS3 popovers set this below */
    $(function () { 
        $("[data-toggle='popover']").popover(); 
    });
    SCRIPT;
    // Register tooltip/popover initialization javascript
    $this->registerJs($js);
