CREATE DEFINER=`root`@`%` PROCEDURE `sistema`.`cancelar_solicitudes_duplicadas`(IN p_solId VARCHAR(5))
BEGIN
    DECLARE v_ambIdFk INT;
    DECLARE v_horIDFk INT;
    DECLARE v_fecha DATE;

    -- Obtener datos de la solicitud recién aprobada
    SELECT ambIdFk, horIDFk, fecha
    INTO v_ambIdFk, v_horIDFk, v_fecha
    FROM solicitud
    WHERE solId = p_solId;

    -- Cancelar las demás solicitudes con mismo salón, horario y fecha
    UPDATE solicitud
    SET solEst = 2
    WHERE ambIdFk = v_ambIdFk
      AND horIDFk = v_horIDFk
      AND fecha = v_fecha
      AND solEst = 0
      AND solId != p_solId;

END