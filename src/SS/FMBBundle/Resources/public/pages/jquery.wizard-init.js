/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Form wizard page
 */

!function ($) {
    "use strict";

    var FormWizard = function () {
    };

    FormWizard.prototype.createBasic = function ($form_container) {
        $form_container.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onFinishing: function (event, currentIndex) {
                //NOTE: Here you can do form validation and return true or false based on your validation logic
                console.log("Form has been validated!");
                return true;
            },
            onFinished: function (event, currentIndex) {
                //NOTE: Submit the form, if all validation passed.
                console.log("Form can be submitted using submit method. E.g. $('#basic-form').submit()");
                $("#basic-form").submit();

            }
        });
        return $form_container;
    },
        //creates form with validation
        FormWizard.prototype.createValidatorForm = function ($form_container) {
            $form_container.validate({
                errorPlacement: function errorPlacement(error, element) {
                    element.after(error);
                }
            });
            $form_container.children("div").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                onStepChanging: function (event, currentIndex, newIndex) {
                    $form_container.validate().settings.ignore = ":disabled,:hidden";
                    return $form_container.valid();
                },
                onFinishing: function (event, currentIndex) {
                    $form_container.validate().settings.ignore = ":disabled";
                    return $form_container.valid();
                },
                onFinished: function (event, currentIndex) {
                    //Routing.generate('ssfmb_PochPreparer', { parc: $("input[name='parc']").val(), corde: "bar", nbrCorde: "bar", contenu: "bar" });
                    //alert("Submitted!");
                    var nombreCordeChoisie = $('input[name="nbrCordeAssemblage"]').val();
                    var nombreCordeDemande = $('#nbrCorde').text();
                    var op = 0;
                    var quantiter = 0;
                    var quantiterDemander = 0;
                    var quantiterU = 0;
                    var ok = true;
                    if (nombreCordeChoisie > nombreCordeDemande) {
                        alert('vous avez demander a preparer un nombre de corde superieur au nombre de corde en stock');
                    } else {
                        $.each($(':hidden.contenu'), function (index, value) {
                            op++;
                            switch (op) {
                                case 1:
                                    //nbrCorde
                                    quantiter = parseInt($(value).val());
                                    break;
                                case 2:
                                    //nombreSaisie
                                    quantiterDemander = parseInt($(value).val());
                                    break;
                                case 3:
                                    //pocheChoisie
                                    break;
                                //datePocheChoisie
                                case 4:
                                    //densite choisie
                                    break;
                                case 5:
                                    quantiterU = parseInt($(value).val());
                                    console.log(quantiterDemander);
                                    console.log(nombreCordeChoisie);
                                    console.log(quantiter);
                                    console.log(quantiterU);
                                    if ((quantiterDemander * nombreCordeChoisie) > quantiter) {
                                        alert("il vous manque " + ((quantiterDemander * nombreCordeChoisie) - quantiter) + " poche H de quantiter " + quantiterU + "pour effectué cette operation");
                                        ok = false;
                                    }
                                    op = 0;
                                    break;
                                default:
                                    console.log('erreur');
                            }
                        });
                        if (ok) {
                            $("#wizard-validation-form").submit();
                        } else {
                            alert('operation non effectué veillez verifié vos valeurs');
                        }
                    }
                }
            });

            return $form_container;
        },
        //creates vertical form
        FormWizard.prototype.createVertical = function ($form_container) {
            $form_container.steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "fade",
                stepsOrientation: "vertical"
            });
            return $form_container;
        },
        FormWizard.prototype.init = function () {
            //initialzing various forms

            //basic form
            this.createBasic($("#basic-form"));

            //form with validation
            this.createValidatorForm($("#wizard-validation-form"));

            //vertical form
            this.createVertical($("#wizard-vertical"));
        },
        //init
        $.FormWizard = new FormWizard, $.FormWizard.Constructor = FormWizard
}(window.jQuery),

//initializing 
    function ($) {
        "use strict";
        $.FormWizard.init()
    }(window.jQuery);