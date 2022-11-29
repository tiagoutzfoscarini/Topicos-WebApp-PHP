// function check_form_value(errorArray, formName, field, fieldName) {
//     if (document.getElementById(formName).elements[field].value === "") {
//         let errorMsg = fieldName + " não pode ser vazio";
//         errorArray.push(errorMsg);
//         return [errorArray, false];
//     } else {
//         return [errorArray, true];
//     }
// }
//
// function validate_form () {
//     // event.preventDefault();
//     const formName = 'newProtocolForm';
//     const fieldsToCheck = ['problemType', 'description', 'name', 'cpf', 'tel', 'city', 'address'];
//     const fieldsNames = ['Tipo de problema', 'Descrição', 'Nome', 'CPF', 'Telefone', 'Cidade', 'Endereço'];
//
//     let valid = [];
//     let errors = [];
//
//     // let fields = document.getElementById(formName).elements;
//     for (let i = 0; i < fieldsToCheck.length; i++) {
//         let results = check_form_value(errors, formName, fieldsToCheck[i], fieldsNames[i]);
//
//         if (fieldsToCheck[i] === 'cpf') {
//             if (!validate_cpf(document.getElementById(formName).elements[fieldsToCheck[i]].value)) {
//                 results[0].push('CPF inválido');
//                 results[1] = false;
//             }
//         } else if (fieldsToCheck[i] === 'tel') {
//             if (!validate_tel(document.getElementById(formName).elements[fieldsToCheck[i]].value)) {
//                 results[0].push('Telefone inválido');
//                 results[1] = false;
//             }
//         }
//         errors = results[0];
//         valid.push(results[1]);
//     }
//
//     if (valid.includes(false)) {
//         console.log(errors);
//         alert(errors.join("\n"));
//         return false;
//
//     } else {
//         document.getElementById(formName).submit();
//         return true;
//     }
// }
//
// function validate_cpf(cpf) {
//     cpf = cpf.replace(/[^\d]+/g,'');
//     if(cpf == '') return false;
//     // Elimina CPFs invalidos conhecidos
//     if (cpf.length != 11 ||
//         cpf == "00000000000" ||
//         cpf == "11111111111" ||
//         cpf == "22222222222" ||
//         cpf == "33333333333" ||
//         cpf == "44444444444" ||
//         cpf == "55555555555" ||
//         cpf == "66666666666" ||
//         cpf == "77777777777" ||
//         cpf == "88888888888" ||
//         cpf == "99999999999")
//         return false;
//     // Valida 1o digito
//     add = 0;
//     for (i=0; i < 9; i ++)
//         add += parseInt(cpf.charAt(i)) * (10 - i);
//     rev = 11 - (add % 11);
//     if (rev == 10 || rev == 11)
//         rev = 0;
//     if (rev != parseInt(cpf.charAt(9)))
//         return false;
//     // Valida 2o digito
//     add = 0;
//     for (i = 0; i < 10; i ++)
//         add += parseInt(cpf.charAt(i)) * (11 - i);
//     rev = 11 - (add % 11);
//     if (rev == 10 || rev == 11)
//         rev = 0;
//     if (rev != parseInt(cpf.charAt(10)))
//         return false;
//     return true;
// }
//
// function validate_tel(telefone) {
//     //retira todos os caracteres menos os numeros
//     telefone = telefone.replace(/\D/g, '');
//
//
//     //verifica se tem a qtde de numero correto
//     if (!(telefone.length >= 10 && telefone.length <= 11)) return false;
//
//     //Se tiver 11 caracteres, verificar se começa com 9 o celular
//     if (telefone.length == 11 && parseInt(telefone.substring(2, 3)) != 9) return false;
//
//     //verifica se não é nenhum numero digitado errado (propositalmente)
//     for (var n = 0; n < 10; n++) {
//         //um for de 0 a 9.
//         //estou utilizando o metodo Array(q+1).join(n) onde "q" é a quantidade e n é o
//         //caractere a ser repetido
//         if (telefone == new Array(11).join(n) || telefone == new Array(12).join(n)) return false;
//     }
//     //DDDs validos
//     var codigosDDD = [11, 12, 13, 14, 15, 16, 17, 18, 19,
//         21, 22, 24, 27, 28, 31, 32, 33, 34,
//         35, 37, 38, 41, 42, 43, 44, 45, 46,
//         47, 48, 49, 51, 53, 54, 55, 61, 62,
//         64, 63, 65, 66, 67, 68, 69, 71, 73,
//         74, 75, 77, 79, 81, 82, 83, 84, 85,
//         86, 87, 88, 89, 91, 92, 93, 94, 95,
//         96, 97, 98, 99];
//     //verifica se o DDD é valido (sim, da pra verificar rsrsrs)
//     if (codigosDDD.indexOf(parseInt(telefone.substring(0, 2))) == -1) return false;
//
//     //  E por ultimo verificar se o numero é realmente válido. Até 2016 um celular pode
//     //ter 8 caracteres, após isso somente numeros de telefone e radios (ex. Nextel)
//     //vão poder ter numeros de 8 digitos (fora o DDD), então esta função ficará inativa
//     //até o fim de 2016, e se a ANATEL realmente cumprir o combinado, os numeros serão
//     //validados corretamente após esse período.
//     //NÃO ADICIONEI A VALIDAÇÂO DE QUAIS ESTADOS TEM NONO DIGITO, PQ DEPOIS DE 2016 ISSO NÃO FARÁ DIFERENÇA
//     //Não se preocupe, o código irá ativar e desativar esta opção automaticamente.
//     //Caso queira, em 2017, é só tirar o if.
//     if (new Date().getFullYear() < 2017) return true;
//     if (telefone.length == 10 && [2, 3, 4, 5, 7].indexOf(parseInt(telefone.substring(2, 3))) == -1) return false;
//
//     //se passar por todas as validações acima, então está tudo certo
//     return true;
// }
