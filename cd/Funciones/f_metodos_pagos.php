<?php
    function ArmarDataParaInsertar($data_visa, $reserva_id) {
        $data = array(
            'reserva_id' => $reserva_id,
            'ecore_transaction_uiid' => $data_visa->header->ecoreTransactionUUID,
        );

        if (isset($data_visa->errorCode)) {
            $data['action_code'] = $data_visa->errorCode;
            $data['action_description'] = $data_visa->errorMessage;
        }
        if (isset($data_visa->order)) {
            // $data['reserva_id'] = $data_visa->order->purchaseNumber;
            $data['token_id'] = $data_visa->order->tokenId;
            $data['purchase_number'] = $data_visa->order->purchaseNumber;
            $data['amount'] = $data_visa->order->amount;
            $data['authorized_amount'] = $data_visa->order->authorizedAmount;
            $data['authorization_code'] = $data_visa->order->authorizationCode;
            $data['transaction_id'] = $data_visa->order->transactionId;
        }
        if (isset($data_visa->data)) {
            $data['brand'] = $data_visa->data->BRAND;
            $data['eci_code'] = (!isset($data_visa->data->ECI))? '' : $data_visa->data->ECI; ;
            $data['action_code'] = $data_visa->data->ACTION_CODE;
            $data['card'] = (!isset($data_visa->data->CARD)) ? '': $data_visa->data->CARD;
            $data['merchant'] = !isset($data_visa->data->MERCHANT) ? NULL : $data_visa->data->MERCHANT;
            $data['status'] = $data_visa->data->STATUS;
            $data['action_description'] = $data_visa->data->ACTION_DESCRIPTION;
            $data['adquiriente'] = (!isset($data_visa->data->ADQUIRENTE)) ? NULL : $data_visa->data->ADQUIRENTE;
            $data['amount'] = $data_visa->data->AMOUNT;
        } 
        else if (isset($data_visa->dataMap)) {
            $data['brand'] = $data_visa->dataMap->BRAND;
            $data['eci_code'] = !isset($data_visa->dataMap->ECI) ? '' : $data_visa->dataMap->ECI;
            $data['action_code'] = $data_visa->dataMap->ACTION_CODE;
            $data['card'] = $data_visa->dataMap->CARD;
            $data['merchant'] = !isset($data_visa->dataMap->MERCHANT) ? NULL : $data_visa->dataMap->MERCHANT;
            $data['status'] = $data_visa->dataMap->STATUS;
            $data['action_description'] = $data_visa->dataMap->ACTION_DESCRIPTION;
            $data['adquiriente'] = !isset($data_visa->dataMap->ADQUIRENTE) ? NULL : $data_visa->dataMap->ADQUIRENTE;
            $data['quota_amount'] = (isset($data_visa->dataMap->QUOTA_AMOUNT)) ? $data_visa->dataMap->QUOTA_AMOUNT : NULL;
            $data['quota_number'] = (isset($data_visa->dataMap->QUOTA_NUMBER)) ? $data_visa->dataMap->QUOTA_NUMBER : NULL;
            $data['id_unico'] = $data_visa->dataMap->ID_UNICO;
            $data['quota_deferred'] = (isset($data_visa->dataMap->QUOTA_DEFERRED)) ? $data_visa->dataMap->QUOTA_DEFERRED : NULL;
        }

        return $data;
    }

    function ArmarDataInsertarReservaNuevo($reserva)
    {
        $data['CodigoReserva']=$reserva->CodigoReserva;
        $data['Apellidos']=$reserva->Apellidos;
        $data['Nombres']=$reserva->Nombres;
        $data['Tipo_Doc']=$reserva->Tipo_Doc;
        $data['Documento']=$reserva->Documento;
        if ($reserva->ddi_Telefono) {
            $data['ddi_Telefono']=$reserva->ddi_Telefono;
        }
        if ($reserva->pre_Telefono) {
            $data['pre_Telefono']=$reserva->pre_Telefono;
        }
        if ($reserva->Telefono) {
            $data['Telefono']=$reserva->Telefono;
        }
        if ($reserva->ddi_Celular) {
            $data['ddi_Celular']=$reserva->ddi_Celular;
        }
        if ($reserva->pre_Celular) {
            $data['pre_Celular']=$reserva->pre_Celular;
        }
        if ($reserva->Celular) {
            $data['Celular']=$reserva->Celular;
        }
        $data['Email']=$reserva->Email;
        $data['FechaRegistro']=$reserva->FechaRegistro;
        $data['FechaLimite']=$reserva->FechaLimite;
        $data['TipoVuelo']=$reserva->TipoVuelo;
        $data['Adultos']=$reserva->Adultos;
        $data['Ninos']=$reserva->Ninos;
        $data['Bebes']=$reserva->Bebes;
        $data['Origen']=$reserva->Origen;
        $data['Destino']=$reserva->Destino;
        $data['Vuelo_Salida']=$reserva->Vuelo_Salida;
        $data['Clase_Salida']=$reserva->Clase_Salida;
        $data['Fecha_Salida']=$reserva->Fecha_Salida;
        $data['Hora_Salida']=$reserva->Hora_Salida;
        if ($reserva->Vuelo_Retorno) {
            $data['Vuelo_Retorno']=$reserva->Vuelo_Retorno;
        }
        if ($reserva->Clase_Retorno) {
            $data['Clase_Retorno']=$reserva->Clase_Retorno;
        }
        $data['Fecha_Retorno']=$reserva->Fecha_Retorno;
        $data['Hora_Retorno']=$reserva->Hora_Retorno;
        $data['Pais']=$reserva->Pais;
        $data['Ciudad']=$reserva->Ciudad;
        $data['IP']=$reserva->IP;
        if ($reserva->Ticket01) {
            $data['Ticket01']=$reserva->Ticket01;
        }
        if ($reserva->Ticket02) {
            $data['Ticket02']=$reserva->Ticket02;
        }
        if ($reserva->Ticket03) {
            $data['Ticket03']=$reserva->Ticket03;
        }
        if ($reserva->Ticket04) {
            $data['Ticket04']=$reserva->Ticket04;
        }
        if ($reserva->Ticket05) {
            $data['Ticket05']=$reserva->Ticket05;
        }
        if ($reserva->Ticket06) {
            $data['Ticket06']=$reserva->Ticket06;
        }
        if ($reserva->Ticket07) {
            $data['Ticket07']=$reserva->Ticket07;
        }
        if ($reserva->Ticket08) {
            $data['Ticket08']=$reserva->Ticket08;
        }
        if ($reserva->Ticket09) {
            $data['Ticket09']=$reserva->Ticket09;
        }
        $data['Flete']=$reserva->Flete;
        $data['TUA']=$reserva->TUA;
        $data['Impuesto']=$reserva->Impuesto;
        $data['Total']=$reserva->Total;
        $data['CodigoEntidad']=$reserva->CodigoEntidad;
        $data['CodigoPersonal']=$reserva->CodigoPersonal;
        $data['EstadoRegistro']=$reserva->EstadoRegistro;
        $data['CronAnular']=$reserva->CronAnular;
        if ($reserva->RUC) {
            $data['RUC']=$reserva->RUC;
        }
        $data['forma_pago']=$reserva->forma_pago;
        $data['Porcentaje']=$reserva->Porcentaje;
        return $data;
    }