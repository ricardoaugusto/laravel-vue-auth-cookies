import { extend, localize } from "vee-validate";
import { min, required, email } from "vee-validate/dist/rules";
import en from "vee-validate/dist/locale/en.json";
// import ptBr from "vee-validate/dist/locale/pt_BR.json";

extend("required", required);
extend("min", min);
extend("email", email);

// localize("pt-BR", ptBr);
localize({ en });
